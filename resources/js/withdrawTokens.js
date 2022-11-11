import presaleAbi from "./abi/presale.json";

export default () => ({
    selectedToken: "null",
    async withdraw(e) {
        if (this.selectedToken === "null") return;
        e.target.disabled = true;

        const { web3 } = this.$store.wallet;
        const { presale_contract_address } = window.settings;
        try {
            const tokenContract = new web3.eth.Contract(
                presaleAbi,
                presale_contract_address
            );

            const tx = await tokenContract.methods
                .withdrawAll(this.selectedToken)
                .send({ from: this.$store.wallet.address });

            toast.success("Token withdrawn successfully");
        } catch (e) {
            toast.error(e?.message || "Something went wrong, please try again");
        }

        e.target.disabled = false;
    },
});
