@section('title')
    Edit {{ $payableToken->name }} Token
@endsection
<x-app-layout>
    <x-card title="Edit {{ $payableToken->name }} Token">
        <x-validation-errors class="pb-6 mb-6 border-b" :errors="$errors" />

        @include('admin.payable-tokens.form', [
            'type' => 'edit',
            'item' => $payableToken,
        ])
    </x-card>
</x-app-layout>
