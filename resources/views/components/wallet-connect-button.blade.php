<div x-data>
    <template x-if="!$store.wallet.connected">
        <button class="gap-2 btn btn-primary-alt btn-sm" type="button" x-on:click="$store.wallet.connect()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
            </svg>

            <span class="hidden lg:inline">Connect to Web3</span>
        </button>
    </template>
    <template x-if="$store.wallet.connected">
        <div
            class="inline-flex items-center gap-2 px-2 py-1 text-xs font-medium rounded-lg lg:px-4 lg:py-2 lg:text-sm text-primary-500 bg-primary-500/20">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M21 12a2.25 2.25 0 00-2.25-2.25H15a3 3 0 11-6 0H5.25A2.25 2.25 0 003 12m18 0v6a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 9m18 0V6a2.25 2.25 0 00-2.25-2.25H5.25A2.25 2.25 0 003 6v3" />
            </svg>

            <span x-text="$store.wallet.address.slice(0, 6) + '...' + $store.wallet.address.slice(-4)"></span>
            <button class="btn btn-danger-alt btn-sm" type="button" @click="$store.wallet.disconnect()">
                Disconnect
            </button>
        </div>
    </template>
</div>
