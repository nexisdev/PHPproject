@section('title')
    Admin Dashboard
@endsection
<x-app-layout>
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-12">
        <x-card class="col-span-12 text-white lg:col-span-4 bg-primary-700">
            <div class="flex flex-wrap items-center gap-4 py-4">
                <div class="flex items-center justify-center w-16 h-16 rounded-full">
                    <img src="{{ \App\Helpers\Cache::settings('token_image') ? Storage::url(\App\Helpers\Cache::settings('token_image')) : asset('images/empty-token.webp') }}"
                        alt="{{ \App\Helpers\Cache::settings('token_symbol') }}" class="w-16 h-16 rounded-full">
                </div>
                <div class="flex flex-col gap-2">
                    <span class="font-semibold uppercase">Total Sold Amount</span>
                    <div class="flex items-end gap-2">
                        <span class="text-2xl">{{ $totalSoldAmount ?? 0 }}
                            <span
                                class="text-xs text-gray-100">{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                        </span>
                    </div>
                </div>
            </div>
            <p class="mt-4 mb-2 font-semibold uppercase">Sold amount in each token</p>
            <div class="flex flex-wrap gap-4">
                @foreach ($soldAmountByToken as $item)
                    <div>
                        <p>{{ $payableTokens->where('id', '=', $item->payable_token)->first()->symbol }}</p>
                        <p>
                            {{ $item->total }}
                            <span
                                class="text-xs text-gray-100">{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                        </p>
                    </div>
                @endforeach
            </div>
        </x-card>

        <x-card class="col-span-12 lg:col-span-4">
            <div class="flex flex-col divide-y divide-gray-100 dark:divide-gray-600">
                @if (\App\Helpers\Cache::settings('token_image'))
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-500 dark:text-gray-200">Token Image</span>
                        <span class="text-gray-900 dark:text-white">
                            <img src="{{ Storage::url(\App\Helpers\Cache::settings('token_image')) }}" alt="Token Logo"
                                class="w-6 h-6">
                        </span>
                    </div>
                @endif
                <div class="flex items-center justify-between py-2">
                    <span class="text-sm text-gray-500 dark:text-gray-200">Token Symbol</span>
                    <span
                        class="text-gray-900 dark:text-white ">{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-sm text-gray-500 dark:text-gray-200">Token Name</span>
                    <span class="text-gray-900 dark:text-white ">{{ \App\Helpers\Cache::settings('token_name') }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-sm text-gray-500 dark:text-gray-200">Token Decimals</span>
                    <span
                        class="text-gray-900 dark:text-white ">{{ \App\Helpers\Cache::settings('token_decimals') }}</span>
                </div>
                <div class="flex items-center justify-between py-2">
                    <span class="text-sm text-gray-500 dark:text-gray-200">Token Price</span>
                    <span class="text-gray-900 dark:text-white ">{{ \App\Helpers\Cache::settings('token_price') }}
                        USD</span>
                </div>
            </div>
        </x-card>
        <x-card x-data="withdrawTokens()" title="Withdraw tokens" class="col-span-12 lg:col-span-4">
            <x-select x-model="selectedToken" name="payable_tokens" class="mb-4">
                <option value="null">Select a token</option>
                @foreach ($payableTokens as $token)
                    <option value="{{ $token->contract_address }}">{{ $token->name }}</option>
                @endforeach
            </x-select>
            <p x-show="!$store.wallet.connected" x-transition class="mb-4 text-sm text-red-500">
                * You need to be connnected to your wallet to withdraw tokens.
            </p>
            <button class="btn btn-primary-alt" :disabled="!$store.wallet.connected" @click="withdraw">Withdraw
                Token
            </button>
        </x-card>
        <x-card class="col-span-12">
            <x-slot:title>
                <div class="flex items-center justify-between">
                    <p class="text-xl font-semibold">Token Sales</p>
                    <p class="text-sm text-gray-500 dark:text-gray-200">Last 90 days</p>
                </div>
            </x-slot:title>
            <canvas id="tokenSales" class="max-h-96" data-data="{{ json_encode($tokenSalesStatistics) }}"> </canvas>
        </x-card>
        @if (\App\Helpers\ModuleHelper::isActive('referral'))
            <div class="col-span-12 lg:col-span-4 flex flex-col gap-4">
                <x-card>
                    <p class="mb-2 text-gray-500 dark:text-gray-200">
                        Total Referral Prizes
                    </p>
                    <h4 class="text-2xl font-semibold">
                        {{ $totalReferralPrizes }} <span
                            class="text-sm text-gray-500 dark:text-gray-200">{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                    </h4>
                </x-card>
                <x-card>
                    <p class="mb-2 text-gray-500 dark:text-gray-200">
                        Total Referral Users
                    </p>
                    <h4 class="text-2xl font-semibold">
                        {{ $totalReferredUsers }} <span class="text-sm text-gray-500 dark:text-gray-200">User</span>
                    </h4>
                </x-card>
                <x-card>
                    <p class="mb-2 text-gray-500 dark:text-gray-200">
                        Total Referral Link Visits
                    </p>
                    <h4 class="text-2xl font-semibold">
                        {{ $totalReferralVisits }} <span class="text-sm text-gray-500 dark:text-gray-200">Visit</span>
                    </h4>
                </x-card>
            </div>
            <x-card class="col-span-12 lg:col-span-8">
                <x-slot:title>
                    <div class="flex items-center justify-between">
                        <p class="text-xl font-semibold">My Referral Visits</p>
                        <p class="text-sm text-gray-500 dark:text-gray-200">Last 90 days</p>
                    </div>
                </x-slot:title>
                <canvas id="referralVisits" class="max-h-60" data-data="{{ json_encode($referralVisits) }}"> </canvas>
            </x-card>
        @endif
        @if (\App\Helpers\ModuleHelper::isActive('kyc'))
            <x-card class="col-span-12 lg:col-span-8">
                <x-slot:title>
                    <div class="flex items-center justify-between">
                        <p class="text-xl font-semibold">KYC Applications</p>
                        <p class="text-sm text-gray-500 dark:text-gray-200">Last 90 days</p>
                    </div>
                </x-slot:title>

                <canvas id="kycApplications" class="max-h-96"
                    data-data="{{ json_encode($kycApplicationsStatistics) }}"> </canvas>
            </x-card>
            <div class="flex flex-col col-span-12 gap-4 lg:col-span-4">
                @php
                    $kycStatusesClass = [
                        'pending' => 'bg-yellow-500/20 text-yellow-700',
                        'approved' => 'bg-green-500/20 text-green-700',
                        'rejected' => 'bg-red-500/20 text-red-700',
                    ];
                @endphp
                @foreach ($kycApplicationsPerStatus as $key => $count)
                    <x-card>
                        <div class="flex flex-wrap items-center gap-4">
                            <div class="p-4 rounded-lg flex items-center {{ $kycStatusesClass[$key] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                                </svg>
                            </div>
                            <div class="flex flex-col gap-1">
                                <p class="text-sm text-gray-500 dark:text-gray-200 uppercase">{{ $key }} KYC
                                    Applications</p>
                                <p class="text-xl font-semibold text-gray-900 dark:text-white">{{ $count }}</p>
                            </div>
                        </div>
                    </x-card>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
