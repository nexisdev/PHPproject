import {
    NETWORK_NATIVE_CURRENCY,
    ZERO_ADDRESS,
    ZERO_AMOUNT,
} from "./constants";
import tokenAbi from "./abi/token.json";
import axios from "axios";

export default ({ tokenId }) => ({
    amount: "",
    output: 0,
    tokenId: tokenId,
    minAmount: window.settings.min_purchase_amount,
    maxAmount: window.settings.max_purchase_amount,
    loading: false,
    get token() {
        const walletStore = Alpine.store("wallet");
        return walletStore.tokens.find((token) => token.id == this.tokenId);
    },
    get minMaxPurchaseAmountPercentage() {
        const walletStore = Alpine.store("wallet");
        const { token_price, min_purchase_amount, max_purchase_amount } =
            window.settings;

        // get percentage of token purchased
        const price = walletStore.balance * token_price;
        const percentage =
            ((price - min_purchase_amount) * 100) /
            (max_purchase_amount - min_purchase_amount);

        return percentage < 0 ? 0 : percentage > 100 ? 100 : percentage;
    },
    fixedNumber(number, fixed = 4) {
        return +Number(number).toFixed(fixed);
    },
    tokenChanged() {
        this.updateOutput();
    },
    updateOutput() {
        if (!this.amount && this.token) {
            this.output = 0;
            return;
        }

        this.output = this.fixedNumber(this.amount / this.token.price, 6);
    },
    checkLimitation(amount) {
        const walletStore = Alpine.store("wallet");

        const { token_price, min_purchase_amount, max_purchase_amount } =
            window.settings;

        const rate = this.token.price;

        if (!rate) return false;
        const balanceInUSD = walletStore.balance * token_price;
        const amountInUSD = (amount / rate) * token_price;
        const totalBalance = balanceInUSD + amountInUSD;
        if (totalBalance < min_purchase_amount) {
            toast.error(`You can not buy less than ${min_purchase_amount} USD`);
            return false;
        } else if (totalBalance > max_purchase_amount) {
            toast.error(`You can not buy more than ${max_purchase_amount} USD`);
            return false;
        }

        return true;
    },
    async buy(e) {
        const walletStore = Alpine.store("wallet");

        const data = e.target;
        const value = data.amount.value;
        if (!+value) return;
        if (!this.checkLimitation(value)) return;

        this.loading = true;
        data.querySelector("button[type=submit]").disabled = true;

        const { presale_contract_address } = window.settings;

        try {
            const amount = walletStore.parseUnit(value, this.token.decimals);
            const payload = {
                bought_amount: this.output,
                paid_amount: value,
                payable_token: this.tokenId,
                wallet_address: walletStore.address,
            };
            if (this.token.symbol === NETWORK_NATIVE_CURRENCY.symbol) {
                const response = await walletStore.presaleContract.methods
                    .buyToken(ZERO_ADDRESS, ZERO_AMOUNT)
                    .send({ from: walletStore.address, value: amount });
                payload.transaction_hash = response.transactionHash;
            } else {
                const tokenContract = new walletStore.web3.eth.Contract(
                    tokenAbi,
                    this.token.contract_address
                );

                const allowance = await tokenContract.methods
                    .allowance(walletStore.address, presale_contract_address)
                    .call();

                if (!Number(allowance)) {
                    await tokenContract.methods
                        .approve(
                            presale_contract_address,
                            walletStore.parseUnit(
                                "9999999999999999999999999999"
                            )
                        )
                        .send({ from: walletStore.address, gas: 300_000 });
                    toast.success("Spend approved");
                }

                const response = await presaleContract.methods
                    .buyToken(this.token.contract_address, amount)
                    .send({ from: walletStore.address, gas: 300_000 });

                payload.transaction_hash = response.transactionHash;
            }

            const { data } = await axios.post("/api/transaction", payload);

            axios
                .post("/api/referral-transaction", {
                    wallet_address: walletStore.address,
                    transaction_id: data.transaction_id,
                })
                .catch(() => {});

            toast.success(
                `You have successfully purchased $${window.settings.token_symbol} Tokens. Thank you!`
            );

            this.amount = "";

            walletStore.fetchBuyersAmount();
        } catch (error) {
            toast.error(error?.message || "Signing failed, please try again!");
        }

        this.loading = false;
        data.querySelector("button[type=submit]").disabled = false;
    },
});
