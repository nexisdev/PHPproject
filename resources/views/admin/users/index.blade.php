@section('title')
    User List
@endsection
<x-app-layout>
    <x-card title="User List">
        @php
            $headers = ['#', 'USER', 'E-MAIL', 'TOTAL INVESTED', 'STATUS', 'Action'];
            $statusTypes = [
                'active' => 'success',
                'suspended' => 'danger',
            ];
        @endphp

        <x-session-status class="mb-6" />

        <form method="GET">
            <div class="flex items-end gap-2 mb-4">
                <x-input-field name="search" placeholder="Search..." label="" :value="request()->get('search')" />

                <button class="btn btn-icon btn-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </div>
        </form>

        <x-table class="min-h-[calc(100vh-270px)]" :headers="$headers">
            @foreach ($users as $user)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        {{ $user->id }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $user->name }}
                    </td>
                    <td class="px-6 py-4">
                        <span class="block mb-2"> {{ $user->email }} </span>
                        <x-badge :type="$user->email_verified_at ? 'success' : 'danger'">
                            {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}
                        </x-badge>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            @if (\App\Helpers\Cache::settings('token_image'))
                                <img src="{{ Storage::url(\App\Helpers\Cache::settings('token_image')) }}"
                                    alt="{{ \App\Helpers\Cache::settings('token_symbol') }}" class="h-5 max-w-full">
                            @endif
                            <span>{{ $user->bought_amount }}</span>
                            <span>{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <x-badge :type="$statusTypes[$user->status]">
                            {{ ucfirst($user->status) }}
                        </x-badge>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('admin.users.show', $user) }}" class="btn btn-primary">Show</a>
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary-alt">Edit</a>
                        </div>
                    </td>
                </tr>
            @endforeach

            <x-slot:pagination>
                {{ $users->links() }}
            </x-slot:pagination>
        </x-table>
    </x-card>
</x-app-layout>
