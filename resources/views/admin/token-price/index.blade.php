@section('title')
    Token Prices
@endsection
<x-app-layout>
    <x-card title="Edit Token Price">
        <x-validation-errors class="pb-6 mb-6 border-b" :errors="$errors" />
        <x-session-status class="mb-6" />

        <form x-data action="{{ route('admin.token-price.update') }}" method="POST"
            @submit.prevent="$store.wallet.updatePrice($event, {{ $payableTokens }})">
            @csrf
            @method('PUT')
            <x-loader x-show="$store.wallet.loading" />
            <div class="grid grid-cols-1 mb-4 lg:grid-cols-2">
                <x-input-field name="token_price" type="decimal" required value="{{ $price }}"
                    x-bind:disabled="!$store.wallet.connected" />
            </div>
            <div class="flex items-center gap-2 mb-6">
                <button class="btn btn-primary" type="submit" x-bind:disabled="!$store.wallet.connected">
                    Update Price
                </button>
                <a href="{{ url()->previous() }}" class="btn btn-secondary-alt">
                    Back
                </a>
            </div>
        </form>
        <h3 class="mb-4 text-gray-500 dark:text-gray-200">Recent Activity</h3>
        <div class="flex flex-col border divide-y divide-gray-100 dark:divide-gray-600 rounded-lg">
            @foreach ($activity as $log)
                <span class="px-4 py-2">#{{ $loop->iteration }} {{ $log->description }} (Old price:
                    {{ number_format(json_decode($log->properties)->old_price, 5) }})</span>
            @endforeach
        </div>
    </x-card>

</x-app-layout>
