// import "./bootstrap";

import Alpine from "alpinejs";

import Swal from "sweetalert2";

import walletStore from "./store/wallet";

import presaleABI from "./abi/presale.json";

import buyToken from "./buyToken";

import Toasteur from "toasteur";

import withdrawTokens from "./withdrawTokens";

import "./charts";

import timer from "./timer";

import Clipboard from "@ryangjchandler/alpine-clipboard";

window.toast = new Toasteur("bottom-center", 5000);

window.Alpine = Alpine;

window.presaleABI = presaleABI;

window.window.confirmModal = (options, callback) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes!",
        customClass: {
            confirmButton:
                "btn !shadow-none " +
                (options.status === "success"
                    ? "btn-success-alt"
                    : "btn-danger-alt"),
            cancelButton: "btn btn-secondary-alt !shadow-none",
        },
        ...options,
    }).then((result) => {
        if (result.isConfirmed) callback();
    });
};

Alpine.data("dropzone", () => ({
    previewUrl: "",
    files: null,
    updatePreview($event) {
        this.files = $event.target.files;

        const reader = new FileReader();

        reader.onload = (e) => {
            this.previewUrl = e.target.result;
        };

        reader.readAsDataURL(this.files[0]);
    },
    clearPreview() {
        this.previewUrl = "";
        this.files = null;
    },
}));

Alpine.store("sidebar", {
    open: false,
    toggle() {
        this.open = !this.open;
    },
});

Alpine.data("buyToken", buyToken);
Alpine.data("withdrawTokens", withdrawTokens);
Alpine.data("timer", timer);
Alpine.store("wallet", walletStore);
Alpine.plugin(
    Clipboard.configure({
        onCopy: () => {
            toast.success("Copied to clipboard");
        },
    })
);

Alpine.start();

// load page connect to wallet if there's a cache provider
document.addEventListener("DOMContentLoaded", () => {
    if (localStorage.getItem("WEB3_CONNECT_CACHED_PROVIDER")) {
        Alpine.store("wallet").connect();
    }
});
