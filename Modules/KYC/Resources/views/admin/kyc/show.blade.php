<x-app-layout>
    <x-card>
        <x-slot:title>
            <div class="flex flex-wrap items-center justify-between gap-4">
                <span>KYC Details</span>
                <div class="flex gap-4">
                    <a href="{{ route('kyc.index') }}" class="btn btn-primary-alt">Back</a>
                    <x-dropdown width="48">
                        <x-slot:trigger>
                            <button class="btn btn-secondary-alt" type="button">
                                <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">
                                    </path>
                                </svg>
                            </button>
                        </x-slot:trigger>

                        <x-slot:content>
                            <form action="{{ route('kyc.status', $kyc) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="status" value="approved">
                                <x-dropdown-link href="#"
                                    onclick="confirmModal({text: 'want to change stauts ({{ $kyc->first_name }} {{ $kyc->last_name }}) to approved?', status: 'success'}, () => this.parentElement.submit())">
                                    Approve
                                </x-dropdown-link>
                            </form>
                            <form action="{{ route('kyc.status', $kyc) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="PUT">
                                <input type="hidden" name="status" value="rejected">
                                <x-dropdown-link href="#"
                                    onclick="confirmModal({text: 'want to change stauts ({{ $kyc->first_name }} {{ $kyc->last_name }}) to rejected?'}, () => this.parentElement.submit())">
                                    Cancel
                                </x-dropdown-link>
                            </form>
                            <hr />
                            <form action="{{ route('kyc.destroy', $kyc) }}" method="POST">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                                <x-dropdown-link href="#"
                                    onclick="confirmModal({text: 'want to delete ({{ $kyc->first_name }} {{ $kyc->last_name }}) kyc?'}, () => this.parentElement.submit())">
                                    Delete
                                </x-dropdown-link>
                            </form>
                        </x-slot:content>
                    </x-dropdown>
                </div>
            </div>
        </x-slot:title>

        @php
            $statusTypes = [
                'pending' => 'warning',
                'approved' => 'success',
                'rejected' => 'danger',
            ];
        @endphp
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-4">
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">
                    Submited On
                </span>
                <span>
                    {{ $kyc->created_at }}
                </span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">
                    Checked By
                </span>
                <span>
                    {{ $kyc->checkedBy?->name ?? '-' }}
                </span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">
                    Checked On
                </span>
                <span>
                    {{ $kyc->checked_at ?? '-' }}
                </span>
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-medium text-gray-500">
                    Status
                </span>
                <span>
                    <x-badge :type="$statusTypes[$kyc->status]">
                        {{ $kyc->status }}
                    </x-badge>
                </span>
            </div>
        </div>
        <hr class="my-6 -mx-6" />
        <div class="my-4 text-xl font-semibold text-primary-700">
            Personal Information
        </div>
        <div class="flex flex-col overflow-hidden border divide-y rounded-lg">
            <div class="flex flex-col py-4 lg:divide-x lg:py-0 lg:flex-row">
                <span class="w-48 px-4 py-0 font-medium text-gray-500 lg:py-4">First Name</span>
                <span class="px-4 py-0 lg:py-4">{{ $kyc->first_name }}</span>
            </div>
            <div class="flex flex-col py-4 lg:divide-x lg:py-0 lg:flex-row">
                <span class="w-48 px-4 py-0 font-medium text-gray-500 lg:py-4">Last Name</span>
                <span class="px-4 py-0 lg:py-4">{{ $kyc->last_name }}</span>
            </div>
            <div class="flex flex-col py-4 lg:divide-x lg:py-0 lg:flex-row">
                <span class="w-48 px-4 py-0 font-medium text-gray-500 lg:py-4">Phone Number</span>
                <span class="px-4 py-0 lg:py-4">{{ $kyc->phone_number }}</span>
            </div>
            <div class="flex flex-col py-4 lg:divide-x lg:py-0 lg:flex-row">
                <span class="w-48 px-4 py-0 font-medium text-gray-500 lg:py-4">Full Address</span>
                <span class="px-4 py-0 lg:py-4">{{ $kyc->address_line_1 }}, {{ $kyc->address_line_2 }},
                    {{ $kyc->city }},
                    {{ $kyc->zip_code }}</span>
            </div>
            <div class="flex flex-col py-4 lg:divide-x lg:py-0 lg:flex-row">
                <span class="w-48 px-4 py-0 font-medium text-gray-500 lg:py-4">State</span>
                <span class="px-4 py-0 lg:py-4">{{ $kyc->state }}</span>
            </div>
            <div class="flex flex-col py-4 lg:divide-x lg:py-0 lg:flex-row">
                <span class="w-48 px-4 py-0 font-medium text-gray-500 lg:py-4">Wallet Address</span>
                <span class="px-4 py-0 lg:py-4">{{ $kyc->wallet_address }}</span>
            </div>
            <div class="flex flex-col py-4 lg:divide-x lg:py-0 lg:flex-row">
                <span class="w-48 px-4 py-0 font-medium text-gray-500 lg:py-4">{{ $kyc->document_type->label }}</span>
                <div class="flex-grow px-4 py-0 lg:py-4">
                    <span class="block mb-3 text-gray-700">Front Side</span>
                    <a href="{{ Storage::url($kyc->document_front_side) }}" target="_blank"
                        class="cursor-pointer hover:opacity-80">
                        <img src="{{ Storage::url($kyc->document_front_side) }}" alt="document front side"
                            class="h-32 max-w-full rounded-lg" />
                    </a>
                </div>
                @if ($kyc->document_back_side)
                    <div class="flex-grow px-4 py-0 lg:py-4">
                        <span class="block mb-3 text-gray-700">Back Side</span>
                        <a href="{{ Storage::url($kyc->document_back_side) }}" target="_blank"
                            class="cursor-pointer hover:opacity-80">
                            <img src="{{ Storage::url($kyc->document_back_side) }}" alt="document back side"
                                class="h-32 max-w-full rounded-lg" />
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </x-card>
</x-app-layout>
