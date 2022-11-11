@section('title')
    Show All Payable Tokens
@endsection
<x-app-layout>
    <x-card title="Payable Tokens List">
        @php
            $headers = ['#', 'Token', 'Decimals', 'Contract Address', 'Status', 'Action'];
        @endphp

        <div class="flex justify-end mb-6">
            <a href="{{ route('payable-tokens.create') }}" class="capitalize btn btn-primary">Add new payable token</a>
        </div>

        <x-session-status class="mb-6" />

        <x-table class="min-h-[calc(100vh-320px)]" :headers="$headers">
            @forelse ($tokens as $item)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <img src="{{ Storage::url($item->image) }}" class="h-10 max-w-full"
                                alt="{{ $item->symbol }}">
                            <div class="flex flex-col">
                                <span class="mb-1 font-semibold">{{ $item->symbol }}</span>
                                <span class="text-gray-500 dark:text-gray-200">{{ $item->name }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->decimals }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->contract_address }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($item->status)
                            <x-badge type="success">Active</x-badge>
                        @else
                            <x-badge type="danger">Inactive</x-badge>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <x-dropdown width="48">
                            <x-slot:trigger>
                                <button class="btn btn-sm btn-secondary-alt" type="button">
                                    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                        </path>
                                    </svg>
                                </button>
                            </x-slot:trigger>

                            <x-slot:content>
                                <x-dropdown-link href="{{ route('payable-tokens.edit', $item) }}"> Edit
                                </x-dropdown-link>
                                <hr class="border-gray-100 dark:border-gray-600" />
                                <form action="{{ route('payable-tokens.destroy', $item) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <x-dropdown-link href="#"
                                        onclick="confirmModal({text: 'Want to delete ({{ $item->symbol }}) token?'}, () => this.closest('form').submit())">
                                        Delete
                                    </x-dropdown-link>
                                </form>
                            </x-slot:content>
                        </x-dropdown>
                    </td>
                </tr>
            @empty
                <tr>
                    <th colspan="{{ count($headers) }}"
                        class="w-full p-6 text-lg font-semibold text-center text-gray-500 dark:text-gray-200">
                        There's no tokens yet. <a href="{{ route('payable-tokens.create') }}" class="text-blue-500">Add
                            new token</a>
                    </th>
                </tr>
            @endforelse

            <x-slot:pagination>
                {{ $tokens->links() }}
            </x-slot:pagination>
        </x-table>
    </x-card>
</x-app-layout>
