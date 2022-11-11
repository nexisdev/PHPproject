@section('title')
    User Profile
@endsection
<x-app-layout>
    <div class="grid grid-cols-1 gap-6 mb-6 lg:grid-cols-3">
        <div class="flex flex-col order-first col-span-3 gap-6 lg:col-span-1 lg:order-last">
            <x-card>
                <div class="flex flex-col gap-3">
                    <div class="flex flex-wrap items-center gap-2">
                        <div class="flex items-center justify-center w-16 h-16 bg-gray-200 rounded-full">
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
                        @if (\App\Helpers\ModuleHelper::isActive('kyc') && $user->kyc)
                            <x-badge :type="$user->kyc->status == 'approved' ? 'success' : 'danger'">
                                KYC {{ $user->kyc->status }}
                            </x-badge>
                        @endif
                    </div>
                </div>
            </x-card>
            <x-card class="text-white bg-primary-700">
                <div class="flex flex-wrap items-center gap-4 py-4">
                    <div class="flex items-center justify-center w-16 h-16 bg-gray-100 rounded-full">
                        <img src="{{ Storage::url(\App\Helpers\Cache::settings('token_image')) }}"
                            alt="{{ \App\Helpers\Cache::settings('token_symbol') }}" class="w-16 h-16 rounded-full">
                    </div>
                    <div class="flex flex-col gap-2">
                        <span class="font-semibold uppercase">Total Balance</span>
                        <div class="flex items-end gap-2">
                            <span class="text-2xl">{{ $user->bought_amount ?? 0 }}
                                <span
                                    class="text-xs text-gray-100">{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </x-card>
        </div>
        <x-card class="col-span-3 lg:col-span-2" title="User Profile">
            @php
                $tabs = [
                    [
                        'title' => 'Info',
                        'route' => route('admin.users.show', $user),
                        'active' => request()->routeIs('admin.users.show'),
                    ],
                    [
                        'title' => 'Transactions',
                        'route' => route('admin.users.transactions', $user),
                        'active' => request()->routeIs('admin.users.transactions'),
                    ],
                ];
            @endphp
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

    <!-- Make transaction table -->

</x-app-layout>
