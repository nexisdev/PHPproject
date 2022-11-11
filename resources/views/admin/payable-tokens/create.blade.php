@section('title')
    Create Payable Token
@endsection
<x-app-layout>
    <x-card title="Add new payable token">
        <x-validation-errors class="pb-6 mb-6 border-b" :errors="$errors" />

        @include('admin.payable-tokens.form', [
            'type' => 'create',
            'item' => null,
        ])
    </x-card>
</x-app-layout>
