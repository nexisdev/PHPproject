@extends('admin.users.profile-layout')

@section('content')
    <!-- create 2 columns of input field to show user details: name, email, kyc wallet address -->
    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
        <x-input-field name="name" :value="$user->name" disabled />
        <x-input-field name="email" :value="$user->email" disabled />

    </div>
    @if (\App\Helpers\ModuleHelper::isActive('kyc') && $user->kyc)
        <div class="my-4 text-xl font-semibold text-primary-700">
            KYC Information
        </div>
        <div class="grid grid-cols-1 gap-4 mb-6 lg:grid-cols-2">
            <x-input-field name="first_name" type="text" disabled :value="$user->kyc->first_name" />
            <x-input-field name="last_name" type="text" disabled :value="$user->kyc->last_name" />
            <x-input-field name="phone_number" type="text" disabled :value="$user->kyc->phone_number" />
            <div class="col-span-1 text-lg font-semibold lg:col-span-2 text-primary-700">
                Your Address
            </div>
            <x-input-field name="address_line_1" type="text" disabled :value="$user->kyc->address_line_1" />
            <x-input-field name="address_line_2" type="text" disabled :value="$user->kyc->address_line_2" />
            <x-input-field name="city" type="text" disabled :value="$user->kyc->city" />
            <x-input-field name="state" type="text" disabled :value="$user->kyc->state" />
            <x-input-field name="zip_code" type="text" disabled :value="$user->kyc->zip_code" />
            <x-input-field name="wallet_address" disabled :value="$user->kyc->wallet_address" />
        </div>
    @endif
@endsection
