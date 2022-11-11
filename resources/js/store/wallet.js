import Web3Modal from "web3modal";
// import WalletConnectProvider from "@walletconnect/web3-provider";
import Web3 from "web3";
import {
    COINAPI_KEY,
    NETWORK_ID,
    NETWORK_NAME,
    NETWORK_NATIVE_CURRENCY,
    NETWORK_URL,
} from "../constants";
import presaleAbi from "../abi/presale.json";
import axios from "axios";
import tokenAbi from "../abi/token.json";

const providerOptions = {
    // walletconnect: {
    //     package: WalletConnectProvider,
    //     options: {
    //         rpc: {
    //             [NETWORK_ID]: NETWORK_URL,
    //         },
    //         chainId: NETWORK_ID,
    //     },
    // },
};

const web3Modal = new Web3Modal({
    network: "mainnet", // optional
    cacheProvider: true, // optional
    providerOptions, // required
});

const unitMap = {
    0: "wei",
    3: "kwei",
    6: "mwei",
    9: "gwei",
    12: "szabo",
    15: "finney",
    18: "ether",
};

const walletStore = {
    connected: false,
    address: null,
    web3: null,
    provider: null,
    balance: 0,
    tokens: [],
    presaleContract: null,
    loading: false,
    formatUnit(number, decimals = 18) {
        return this.web3.utils.fromWei(number, unitMap[decimals]);
    },
    parseUnit(number, decimals = 18) {
        return this.web3.utils.toWei(number, unitMap[decimals]);
    },
    isSameWallet(address) {
        if (address === "true") return true;
        else return this.address === address;
    },
    async connect() {
        this.provider = await web3Modal.connect();
        if (this.provider) {
            try {
                this.web3 = new Web3(this.provider);

                const accounts = await this.web3.eth.getAccounts();

                this.provider.on("accountsChanged", () => this.getAccount());

                this.provider.on("chainChanged", () => this.getAccount());

                this.address = accounts[0];

                if (this.address) this.connected = true;

                if (!(await this.checkNetwork())) return;

                this.presaleContract = new this.web3.eth.Contract(
                    presaleAbi,
                    window.settings.presale_contract_address
                );

                await this.getAccount();
            } catch (e) {
                console.log(e);
            }
        }
    },
    async disconnect() {
        if (this.provider.close) {
            await this.provider.close();
            this.provider = null;
        }

        await web3Modal.clearCachedProvider();

        this.address = "";
        this.connected = false;
    },
    async checkNetwork() {
        if (NETWORK_ID === (await this.web3.eth.net.getId())) return true;

        toast.error("Please switch to " + NETWORK_NAME + " network");

        try {
            await window.ethereum.request({
                method: "wallet_switchEthereumChain",
                params: [{ chainId: this.web3.utils.toHex(NETWORK_ID) }],
            });
        } catch (err) {
            // This error code indicates that the chain has not been added to MetaMask
            if (err.code !== 4902) {
                // toast.error("Please switch to BSC Network");
                toast.error("Something went wrong: " + err?.message);
                return false;
            }

            await window.ethereum.request({
                method: "wallet_addEthereumChain",
                params: [
                    {
                        chainName: NETWORK_NAME,
                        chainId: this.web3.utils.toHex(NETWORK_ID),
                        nativeCurrency: NETWORK_NATIVE_CURRENCY,
                        rpcUrls: [NETWORK_URL],
                    },
                ],
            });
        }
    },
    async getAccount() {
        const accounts = await this.web3.eth.getAccounts();

        if (accounts && accounts.length > 0) this.address = accounts[0];

        if (!(await this.checkNetwork())) return;

        this.tokens.forEach(async (token) => {
            if (token.symbol === NETWORK_NATIVE_CURRENCY.symbol) {
                token.balance = this.formatUnit(
                    await this.web3.eth.getBalance(this.address)
                );

                token.price = this.formatUnit(
                    await this.presaleContract.methods.rate().call()
                );
                return;
            }

            const contract = new this.web3.eth.Contract(
                tokenAbi,
                token.contract_address
            );
            const tokenBalance = await contract.methods
                .balanceOf(this.address)
                .call();

            token.balance = this.formatUnit(tokenBalance, token.decimals);

            const rateOfToken = await this.presaleContract.methods
                .tokenPrices(token.contract_address)
                .call();

            token.price = this.formatUnit(rateOfToken, token.decimals);
        });

        // this.tokens = [...tokens.value];

        this.fetchBuyersAmount();

        // fetchTotalTokensSold();

        // loading.value = false;
    },
    async setTokens(tokens) {
        this.tokens = tokens;
    },
    async fetchBuyersAmount() {
        const tokenContract = new this.web3.eth.Contract(
            tokenAbi,
            window.settings.token_contract_address
        );
        const balance = await tokenContract.methods
            .balanceOf(this.address)
            .call();
        this.balance = +Number(
            this.formatUnit(
                this.web3.utils.toBN(balance),
                window.settings.token_decimals
            )
        ).toFixed(4);
    },
    async updatePrice(e, payableTokens) {
        const form = e.target;

        // disable submit button to prevent double submit
        this.loading = true;
        form.querySelector("button[type=submit]").disabled = true;

        // get field value from from that has id token_price
        const price = form.token_price.value;

        const tokens = [];
        const prices = [];
        try {
            payableTokens.forEach((token) => {
                if (token.symbol === NETWORK_NATIVE_CURRENCY.symbol) return;
                tokens.push(token.contract_address);
                prices.push((price * 10 ** token.decimals).toString());
            });

            // get BNB price in usd
            const bnbPrice = await axios.get(
                `https://rest.coinapi.io/v1/exchangerate/BNB/USD?apikey=${COINAPI_KEY}`
            );

            const rate = (
                (price / bnbPrice.data.rate).toFixed(18) *
                10 ** 18
            ).toString();

            await this.presaleContract.methods
                .updateTokenRate(tokens, prices, rate)
                .send({ from: this.address });

            form.submit();
        } catch (e) {
            toast.error("Something went wrong, please try again");
        }

        this.loading = false;
        form.querySelector("button[type=submit]").disabled = false;
    },
    async addNewToken(e) {
        const form = e.target;
        const tokenAddress = form.contract_address.value;
        const symbol = form.symbol.value?.toUpperCase();
        if (symbol === NETWORK_NATIVE_CURRENCY.symbol) {
            form.submit();
            return;
        }

        const decimals = form.decimals.value;

        this.loading = true;
        form.querySelector("button[type=submit]").disabled = true;
        try {
            const newTokenPrice = await axios.get(
                `https://rest.coinapi.io/v1/exchangerate/${symbol}/USD?apikey=${COINAPI_KEY}`
            );

            const tokenPrice = window.settings.token_price;

            const price = (
                (tokenPrice / newTokenPrice.data.rate).toFixed(decimals) *
                10 ** decimals
            ).toString();

            await this.presaleContract.methods
                .addWhiteListedToken([tokenAddress], [price])
                .send({ from: this.address });

            form.submit();
        } catch (e) {
            toast.error("Something went wrong, please try again");
        }

        this.loading = false;
        form.querySelector("button[type=submit]").disabled = false;
    },
};

export default walletStore;
