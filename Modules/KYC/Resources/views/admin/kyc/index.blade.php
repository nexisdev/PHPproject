<x-app-layout>
    <x-card title="KYC List">
        @php
            $headers = ['#', 'USER', 'DOC TYPE', 'Document', 'Status', 'Action'];
            $statusTypes = [
                'pending' => 'warning',
                'approved' => 'success',
                'rejected' => 'danger',
            ];
        @endphp
        <x-session-status class="mb-6" />

        <form method="GET">
            <div class="flex items-end gap-2 mb-4">
                <x-input-field name="search" placeholder="Search..." label="" :value="request()->get('search')" />
                <div class="w-52">
                    <x-select name="status" label="" type="select" :options="[
                        null => 'All Status',
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]" :value="request()->get('status')" />
                </div>

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
            @foreach ($kycList as $item)
                <tr class="bg-white border-b hover:bg-gray-100">
                    <td class="px-6 py-4">
                        {{ $loop->iteration }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->first_name }} {{ $item->last_name }}
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->document_type->label }}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ Storage::url($item->document_front_side) }}"
                            class="text-primary-500 hover:text-primary-700 flex items-center gap-2 font-semibold"
                            target="_blank">
                            Front Side

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                            </svg>


                        </a>
                    </td>
                    <td class="px-6 py-4">
                        <x-badge :type="$statusTypes[$item->status]">
                            {{ $item->status }}
                        </x-badge>
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
                                <x-dropdown-link href="{{ route('kyc.show', $item) }}"> View Details </x-dropdown-link>
                                <form action="{{ route('kyc.status', $item) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="status" value="approved">
                                    <x-dropdown-link href="#"
                                        onclick="confirmModal({text: 'want to change stauts ({{ $item->first_name }} {{ $item->last_name }}) to approved?', status: 'success'}, () => this.parentElement.submit())">
                                        Approve
                                    </x-dropdown-link>
                                </form>
                                <form action="{{ route('kyc.status', $item) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <input type="hidden" name="status" value="rejected">
                                    <x-dropdown-link href="#"
                                        onclick="confirmModal({text: 'want to change stauts ({{ $item->first_name }} {{ $item->last_name }}) to rejected?'}, () => this.parentElement.submit())">
                                        Cancel
                                    </x-dropdown-link>
                                </form>
                                <hr />
                                <form action="{{ route('kyc.destroy', $item) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <x-dropdown-link href="#"
                                        onclick="confirmModal({text: 'want to delete ({{ $item->first_name }} {{ $item->last_name }}) kyc?'}, () => this.parentElement.submit())">
                                        Delete
                                    </x-dropdown-link>
                                </form>
                            </x-slot:content>
                        </x-dropdown>
                    </td>
                </tr>
            @endforeach

            <x-slot:pagination>
                {{ $kycList->links() }}
            </x-slot:pagination>
        </x-table>
    </x-card>
</x-app-layout>
