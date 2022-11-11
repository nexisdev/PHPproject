@section('title')
    {{ auth()->user()->name }} Profile
@endsection
<x-app-layout>
    <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-3">
        <div class="flex flex-col order-first col-span-3 gap-6 lg:col-span-1 lg:order-last">
            <x-card>
                <div class="flex flex-col gap-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <div
                            class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full dark:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                            </svg>
                        </div>
                        <div>
                            <p>{{ $user->name }}</p>
                            <p class="text-gray-500 dark:text-gray-200">{{ $user->email }}</p>
                        </div>

                    </div>
                    <!-- create a grid of 4 columns that show details name, email, is kyc approved, is email verified for the user -->
                    <p class="w-full text-lg font-semibold text-primary-500">Account Status</p>
                    <div class="flex flex-wrap w-full gap-2">
                        <x-badge :type="$user->email_verified_at ? 'success' : 'danger'">
                            Email {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </x-badge>
                        @if (\App\Helpers\ModuleHelper::isActive('kyc'))
                            @if ($user->kyc)
                                <x-badge :type="$user->kyc->status == 'approved' ? 'success' : 'danger'">
                                    KYC {{ $user->kyc->status }}
                                </x-badge>
                            @else
                                <x-badge type="danger">
                                    KYC Not Verified
                                </x-badge>
                            @endif
                        @endif
                    </div>
                </div>
            </x-card>
            <x-card class="text-white bg-primary-700">
                <div class="flex flex-wrap items-center gap-4 py-4">
                    <div class="flex items-center justify-center w-16 h-16 rounded-full">
                        <img src="{{ \App\Helpers\Cache::settings('token_image') ? Storage::url(\App\Helpers\Cache::settings('token_image')) : asset('images/empty-token.webp') }}"
                            alt="{{ \App\Helpers\Cache::settings('token_symbol') }}" class="w-16 h-16 rounded-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="font-semibold uppercase">Total Bought Amount</span>
                        <div class="flex items-end gap-2">
                            <span class="text-2xl">{{ $user->bought_amount ?? 0 }}
                                <span
                                    class="text-xs text-gray-100">{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </x-card>
            <x-card title="Earn with referral">
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-200">
                    This is your referral link. Share it with your friends and earn
                    {{ \App\Helpers\Cache::settings('referral_prize') ?? 0 }}
                    {{ \App\Helpers\Cache::settings('token_symbol') }} of their first purchase.
                </p>
                @if (auth()->user()->wallet_address)
                    <div x-data="{ input: '{{ route('index', ['ref' => auth()->user()->referral_hash]) }}' }" class="flex flex-wrap items-center gap-2">
                        <input type="text" class="form-control" x-model="input" readonly>
                        <button class="btn btn-primary-alt" type="button" @click="$clipboard(input)">
                            Copy Link
                        </button>
                    </div>
                @else
                    <div
                        class="p-3 mb-4 text-sm rounded-lg text-slate-500 bg-slate-500/20 dark:bg-slate-200/20 dark:text-slate-200">
                        You need to add your wallet address to get referral link.
                    </div>
                @endif
            </x-card>
            <x-card title="Two-Factor Verification">
                <p class="mb-6 text-sm text-gray-500 dark:text-gray-200">
                    Two-factor authentication is a method for protection your web account. When it is activated you need
                    to enter not only your password, but also a special code. You can receive this code by in mobile
                    app. Even if third person will find your password, then can't access with that code.
                </p>
                @if (auth()->user()->is_two_factor_auth_enabled)
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <button class="btn btn-danger-alt" type="button" data-modal-toggle="disable-2fa-modal">Disable
                            2FA
                        </button>
                        <x-badge type="success">Enabled</x-badge>
                    </div>
                @else
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <a href="{{ route('profile.enable-2fa') }}" class="btn btn-primary" type="button">Enabale
                            2FA</a>
                        <x-badge type="secondary">Disabled</x-badge>
                    </div>
                @endif

            </x-card>
        </div>
        <x-card class="col-span-3 lg:col-span-2" title="User Profile">
            @php
                $tabs = [
                    [
                        'title' => 'Info',
                        'route' => route('profile.index'),
                        'active' => request()->routeIs('profile.index'),
                    ],
                    [
                        'title' => 'Change Password',
                        'route' => route('profile.change-password'),
                        'active' => request()->routeIs('profile.change-password'),
                    ],
                ];
            @endphp

            <x-session-status class="mb-6" />

            <div
                class="mb-6 text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-200 dark:border-gray-600">
                <ul class="flex flex-wrap -mb-px">
                    @foreach ($tabs as $tab)
                        <li class="mr-2">
                            <a href="{{ $tab['route'] }}"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-gray-700 dark:text-gray-100 transition duration-150 ease-in-out border-b-2 border-transparent focus:outline-none focus:border-primary-500 {{ $tab['active'] ? 'border-primary-500' : '' }}">
                                {{ $tab['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @yield('content')
        </x-card>
    </div>

    @if (auth()->user()->is_two_factor_auth_enabled)
        <div id="disable-2fa-modal" tabindex="-1" aria-hidden="true"
            class="fixed top-0 left-0 right-0 z-50 hidden w-full overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
            <div class="relative w-full h-full max-w-md p-4 md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-slate-900">
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-white rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-toggle="disable-2fa-modal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                    <div class="px-6 py-6 lg:px-8">
                        <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white">Disable Two Factor
                            Authentication
                        </h3>
                        <form class="space-y-6" action="{{ route('profile.disable-2fa.store') }}" method="POST">
                            @csrf
                            <x-input-field type="password" name="password" required />
                            <x-input-field name="one_time_password" label="2FA Code" pattern="[0-9]{6}" required />
                            <button class="justify-center w-full py-4 btn btn-danger-alt">CONFIRM</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

</x-app-layout>
