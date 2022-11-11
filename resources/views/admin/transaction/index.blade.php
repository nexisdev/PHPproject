@section('title')
    Transactions
@endsection
<x-app-layout>
    <x-card title="Transactions">
        @php
            $headers = ['#', 'User', 'Bought Amount', 'Paid Amount', 'Transaction', 'Wallet', 'Date'];
        @endphp
        <x-session-status class="mb-6" />

        <x-table class="min-h-[calc(100vh-270px)]" :headers="$headers">
            @forelse ($transactions as $transaction)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.users.transactions', $transaction->user) }}"
                            class="flex flex-col hover:opacity-80">
                            <span class="text-gray-900 dark:text-white ">{{ $transaction->user->name }}</span>
                            <span class="text-sm text-gray-500 dark:text-gray-200">{{ $transaction->user->email }}</span>
                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            @if (\App\Helpers\Cache::settings('token_image'))
                                <img src="{{ Storage::url(\App\Helpers\Cache::settings('token_image')) }}"
                                    alt="{{ \App\Helpers\Cache::settings('token_symbol') }}" class="h-5 max-w-full">
                            @endif
                            <span>{{ $transaction->bought_amount }}</span>
                            <span>{{ \App\Helpers\Cache::settings('token_symbol') }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-1">
                            <img src="{{ Storage::url($transaction->payableToken->image) }}"
                                alt="{{ $transaction->payableToken->symbol }}" class="h-5 max-w-full">
                            {{ $transaction->paid_amount }}
                            <span>{{ $transaction->payableToken->symbol }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="block w-32 truncate" title="{{ $transaction->transaction_hash }}">
                            {{ $transaction->transaction_hash }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <span class="block w-32 truncate" title="{{ $transaction->wallet_address }}">
                            {{ $transaction->wallet_address }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        {{ $transaction->created_at }}
                    </td>
                </tr>
            @empty
                <tr>
                    <th colspan="{{ count($headers) }}"
                        class="w-full p-6 text-lg font-semibold text-center text-gray-500 dark:text-gray-200">
                        There's no transactions yet, check back later.
                    </th>
                </tr>
            @endforelse


            <x-slot:pagination>
                {{ $transactions->links() }}
            </x-slot:pagination>
        </x-table>
    </x-card>
</x-app-layout>
