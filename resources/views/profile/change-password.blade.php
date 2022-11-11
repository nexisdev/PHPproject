@extends('profile.layout')

@section('content')
    <form action="{{ route('profile.change-password.update') }}" method="POST">
        @csrf
        @method('PUT')
        <x-validation-errors class="mb-4" :errors="$errors" />

        <div class="grid grid-cols-1 gap-4">
            <x-input-field name="current_password" type="password" required />
            <x-input-field name="password" type="password" required />
            <x-input-field name="password_confirmation" type="password" required />
        </div>

        <x-button class="my-6">
            Save
        </x-button>
    </form>
@endsection
