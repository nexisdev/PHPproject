@section('title')
    Buy Token
@endsection

@php
$total_tokens = \App\Helpers\Cache::settings('total_tokens');
$soft_cap = \App\Helpers\Cache::settings('soft_cap');
$hard_cap = \App\Helpers\Cache::settings('hard_cap');
$total_tokens = \App\Helpers\Cache::settings('total_tokens');
@endphp

<x-app-layout>
    <div class="grid gap-6 grid-cols-12">
        <div class="col-span-12 lg:col-span-8">
            <x-card title="Buy Token">
                @php
                    $isKycActive = \App\Helpers\ModuleHelper::isActive('kyc') && \App\Helpers\Cache::settings('is_kyc_enabled');
                    $kycWalletAddress = $isKycActive ? auth()->user()->kyc?->wallet_address : 'true';
                @endphp
                @if ($isKycActive && auth()->user()->kyc?->status != 'approved')
                    @if ('pending' == auth()->user()->kyc?->status)
                        <div class="p-3 mb-4 text-yellow-700 rounded-lg bg-yellow-500/20">
                            Your KYC application is pending. Please wait for the approval.
                        </div>
                    @elseif('rejected' == auth()->user()->kyc?->status)
                        <div class="p-3 mb-4 text-red-700 rounded-lg bg-red-500/20">
                            Your KYC application is rejected. Please contact support.
                        </div>
                    @else
                        <p class="p-3 mb-4 rounded-lg bg-primary-500/20 text-primary-700">
                            You need to complete KYC before you can buy token.
                        </p>
                        <a href="{{ route('kyc.create') }}" class="btn btn-primary-alt">
                            Complete KYC
                        </a>
                    @endif
                @else
                    @php
                        $presaleEndDate = \App\Helpers\Cache::settings('presale_end_date');
                        $presaleStartDate = \App\Helpers\Cache::settings('presale_start_date');
                    @endphp
                    @if ($presaleEndDate && now() > $presaleEndDate)
                        <p class="p-3 mb-4 rounded-lg bg-primary-500/20 text-primary-700">
                            Presale is ended, the presale ended at
                            {{ \Carbon\Carbon::parse($presaleEndDate)->format('d M Y H:i:s') }}
                        </p>
                    @elseif ($presaleStartDate && now() < $presaleStartDate)
                        <p class="p-3 mb-4 rounded-lg bg-primary-500/20 text-primary-700">
                            Presale is not started yet, it will start at
                            {{ \Carbon\Carbon::parse($presaleStartDate)->format('d M, Y h:i A') }}.
                        </p>
                    @else
                        <div x-data x-init="$store.wallet.setTokens({{ json_encode($payableTokens) }})">
                            <div x-show="!$store.wallet.connected" x-transition>
                                <p class="mb-4 text-gray-500 dark:text-gray-200">
                                    You will need to connect to your wallet first before you can buy any tokens.
                                </p>
                                <div class="mb-4">
                                    <x-wallet-connect-button />
                                </div>
                            </div>
                            <div x-show="$store.wallet.connected && !$store.wallet.isSameWallet('{{ $kycWalletAddress }}')"
                                style="display: none" class="p-3 mb-6 text-red-700 rounded-lg bg-red-500/20">
                                Your wallet address must be same as you entered in kyc wallet address, please connect to
                                the
                                correct
                                wallet.
                            </div>
                            <form x-data="buyToken({
                                referrelUser: {{ json_encode($referrelUser) }},
                                tokenId: '{{ isset($payableTokens[0]) ? $payableTokens[0]->id : '' }}'
                            })" @submit.prevent="buy($event)" x-transition
                                style="display: none"
                                x-show="$store.wallet.connected && $store.wallet.isSameWallet('{{ $kycWalletAddress }}')">

                                <x-loader x-show="loading" />

                                <p class="mb-2 text-sm font-bold uppercase text-primary-500">Step 1</p>
                                <p class="mb-4 text-gray-500 dark:text-gray-200">Choose token</p>
                                <div class="grid grid-cols-1 gap-4 mb-6 lg:grid-cols-4 md:grid-cols-2">
                                    @foreach ($payableTokens as $token)
                                        <x-radio-button x-model="tokenId" @change="tokenChanged" name="token"
                                            value="{{ $token->id }}" required>
                                            <div class="flex items-center gap-3">
                                                <img src="{{ Storage::url($token->image) }}" class="h-10 max-w-full"
                                                    alt="{{ $token->symbol }}">
                                                <div class="flex flex-col">
                                                    <span class="mb-1 font-semibold">{{ $token->symbol }}</span>
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-gray-200">{{ $token->name }}</span>
                                                </div>
                                            </div>
                                        </x-radio-button>
                                    @endforeach
                                </div>
                                <p class="mb-2 text-sm font-bold uppercase text-primary-500">Step 2</p>
                                <p class="mb-4 text-gray-500 dark:text-gray-200">
                                    Enter your amount, you would like to contribute and calculate the amount of token
                                    you will received. The calculator helps to convert required currency to tokens.
                                </p>
                                <div class="mb-6">
                                    <x-input-field type="number" name="amount" step="0.0001" required
                                        x-model="amount" @input="updateOutput">
                                        <x-slot name="append">
                                            <div class="flex gap-1">
                                                <span x-text="output"></span>
                                                <span>{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                                            </div>
                                        </x-slot>
                                    </x-input-field>
                                </div>
                                <div class="flex flex-col gap-2 mb-6">
                                    <p>Min-Max Purchase Amount</p>
                                    <div class="w-full h-4 bg-gray-200 rounded-full">
                                        <div class="h-4 rounded-full bg-primary-600"
                                            :style="{
                                                width: `${minMaxPurchaseAmountPercentage}%`
                                            }">
                                        </div>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs text-gray-500 dark:text-gray-200">
                                            {{ \App\Helpers\Cache::settings('min_purchase_amount') ?? 0 }} USD
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-200">
                                            {{ \App\Helpers\Cache::settings('max_purchase_amount') ?? 0 }} USD
                                        </span>
                                    </div>
                                </div>

                                <button class="mb-6 btn btn-primary" type="submit">
                                    Buy Token
                                </button>
                            </form>
                        </div>
                    @endif
                @endif
            </x-card>
        </div>

        <div class="col-span-12 lg:col-span-4">
            <x-card title="Token Sale Progress">
                <div class="flex lg:flex-row flex-col justify-between flex-wrap gap-4 mb-6">
                    <div class="flex flex-col gap-1">
                        <span class="text-gray-500 dark:text-gray-200 text-xs">RASIED AMOUTN</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $raisedAmount }} USD </span>
                    </div>
                    <div class="flex flex-col gap-1 lg:text-right">
                        <span class="text-gray-500 dark:text-gray-200 text-xs">TOTAL TOKENS</span>
                        <span class="font-semibold text-gray-900 dark:text-gray-100">
                            {{ $total_tokens }} USD
                        </span>
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-hcap" style="width: {{ round(($hard_cap / $total_tokens) * 100) }}%;">
                        <div class="">Hard cap <span class="">{{ $hard_cap }} USD</span>
                        </div>
                    </div>
                    <div class="progress-scap" style="width: {{ round(($soft_cap / $total_tokens) * 100) }}%;">
                        <div class="">Soft cap
                            <span>{{ $soft_cap }} USD</span>
                        </div>
                    </div>
                    <div class="progress-percent" style="width: {{ round(($raisedAmount / $total_tokens) * 100) }}%;">
                    </div>
                </div>
            </x-card>
        </div>
    </div>
</x-app-layout>
