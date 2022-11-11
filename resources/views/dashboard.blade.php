@section('title')
    Dashboard
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
                    <span class="font-semibold uppercase">Total Bought Amount</span>
                    <div class="flex items-end gap-2">
                        <span class="text-2xl">{{ $totalBoughtAmount ?? 0 }}
                            <span
                                class="text-xs text-gray-100">{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                        </span>
                    </div>
                </div>
            </div>
            <p class="mt-4 mb-2 font-semibold uppercase">Bought amount in each token</p>
            <div class="flex flex-wrap gap-4">
                @foreach ($boughtAmountByToken as $item)
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
        <div class="flex flex-col col-span-12 gap-4 lg:col-span-4">
            @php
                $presaleEndDate = \App\Helpers\Cache::settings('presale_end_date');
                $presaleStartDate = \App\Helpers\Cache::settings('presale_start_date');
                $isPresaleStarted = $presaleStartDate && $presaleStartDate > now();
            @endphp
            <x-card>
                <h4 class="mb-4 text-xl font-semibold">
                    {{ $isPresaleStarted ? 'Presale will start on' : 'Presale will end on' }}
                </h4>
                <div x-data="timer(new Date('{{ \App\Helpers\Cache::settings($isPresaleStarted ? 'presale_start_date' : 'presale_end_date') }}'))" x-init="init();">
                    <div class="flex items-center justify-center w-full text-4xl text-center">
                        <div x-show="time().months > 0" class="w-24 p-2 mx-1 bg-gray-200 rounded-lg dark:bg-gray-700">
                            <div class="mb-1 font-mono leading-none" x-text="time().months"></div>
                            <div class="font-mono text-sm leading-none uppercase">Months</div>
                        </div>
                        <div class="w-24 p-2 mx-1 bg-gray-200 rounded-lg dark:bg-gray-700">
                            <div class="mb-1 font-mono leading-none" x-text="time().days"></div>
                            <div class="font-mono text-sm leading-none uppercase">Days</div>
                        </div>
                        <div class="w-24 p-2 mx-1 bg-gray-200 rounded-lg dark:bg-gray-700">
                            <div class="mb-1 font-mono leading-none" x-text="time().hours">20</div>
                            <div class="font-mono text-sm leading-none uppercase">Hours</div>
                        </div>
                        <div class="w-24 p-2 mx-1 bg-gray-200 rounded-lg dark:bg-gray-700">
                            <div class="mb-1 font-mono leading-none" x-text="time().minutes"></div>
                            <div class="font-mono text-sm leading-none uppercase">Minutes</div>
                        </div>
                        <div x-show="time().months == 0" class="w-24 p-2 mx-1 bg-gray-200 rounded-lg dark:bg-gray-700">
                            <div class="mb-1 font-mono leading-none" x-text="time().seconds"></div>
                            <div class="font-mono text-sm leading-none uppercase">Seconds</div>
                        </div>
                    </div>
                </div>
            </x-card>
            <x-card>
                <h4 class="mb-4 text-xl font-semibold">Social Links</h4>
                <div class="flex flex-wrap gap-2">
                    <x-social-links :links="\App\Helpers\Cache::settings('socialLinks')"></x-social-links>
                </div>
            </x-card>
        </div>
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
        <x-card class="col-span-12">
            <x-slot:title>
                <div class="flex items-center justify-between">
                    <p class="text-xl font-semibold">My Transactions</p>
                    <p class="text-sm text-gray-500 dark:text-gray-200">Last 90 days</p>
                </div>
            </x-slot:title>
            <canvas id="tokenSales" class="max-h-96" data-data="{{ json_encode($tokenSalesStatistics) }}"> </canvas>
        </x-card>
    </div>
</x-app-layout>
