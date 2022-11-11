@section('title')
    Site Settings
@endsection
<x-app-layout>
    <h1 class="mb-4 text-2xl text-center lg:text-4xl text-primary-700">
        Site Settings
    </h1>
    <h4 class="mb-10 text-center text-gray-500 dark:text-gray-200 lg:text-lg">
        Update your site settings
    </h4>
    <x-card title="Settings">
        <x-validation-errors class="pb-6 mb-6 border-b" :errors="$errors" />
        <x-session-status class="mb-6" />
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <x-input-field name="project_name" value="{{ $settings->project_name }}" type="text" required />
                <x-input-field name="support_email" type="email" value="{{ $settings->support_email }}" required />
                <x-input-field name="notification_email" type="email" value="{{ $settings->notification_email }}"
                    required />
                <x-input-field name="logo" value="{{ $settings->logo }}" type="file" />
                <x-input-field name="tawk_to" type="text" value="{{ $settings->tawk_to }}" />
                <div class="col-span-2 mt-4 text-xl font-semibold text-primary-700">
                    Smart Contract Configuration
                </div>
                <x-input-field name="token_contract_address" value="{{ $settings->token_contract_address }}"
                    type="text" />
                <x-input-field name="presale_contract_address" value="{{ $settings->presale_contract_address }}"
                    type="text" />
                <x-input-field name="token_decimals" value="{{ $settings->token_decimals }}" type="number" required />
                <x-select name="is_min_max_active" description="Minimum and maximum purchase amount."
                    value="{{ $settings->is_min_max_active }}" :options="['0' => 'Disabled', '1' => 'Active']" required></x-select>
                <x-input-field name="min_purchase_amount" value="{{ $settings->min_purchase_amount }}" type="number"
                    description="Price in USD" />
                <x-input-field name="max_purchase_amount" value="{{ $settings->max_purchase_amount }}" type="number"
                    description="Price in USD" />
                <x-input-field name="presale_start_date" value="{{ $settings->presale_start_date }}"
                    type="datetime-local" />
                <x-input-field name="presale_end_date" value="{{ $settings->presale_end_date }}"
                    type="datetime-local" />
                <x-input-field name="soft_cap" value="{{ $settings?->soft_cap }}" type="number" />
                <x-input-field name="hard_cap" value="{{ $settings?->hard_cap }}" type="number" />
                <x-input-field name="total_tokens" value="{{ $settings?->total_tokens }}" type="number" />
                <div></div>
                <x-select name="token_locking" description="Will there be token locking/vesting?"
                    value="{{ $settings->token_locking }}" :options="['0' => 'No', '1' => 'Yes']" required></x-select>
                <x-select name="is_kyc_enabled" description="KYC is an extra module."
                    value="{{ $settings->is_kyc_enabled }}" :options="['0' => 'No', '1' => 'Yes']"></x-select>
                <x-select name="sale_active" description="Is presale active?" value="{{ $settings->sale_active }}"
                    :options="['0' => 'No', '1' => 'Yes']" required></x-select>
                <x-input-field name="token_name" value="{{ $settings->token_name }}" type="text" />
                <x-input-field name="token_symbol" value="{{ $settings->token_symbol }}" type="text" />
                <x-input-field name="token_image" value="{{ $settings->token_image }}" type="file" />
                <div class="col-span-2 mt-4 text-xl font-semibold text-primary-700">
                    Referral Configuration
                </div>
                <x-input-field name="referral_address" value="{{ $settings->referral_address }}" type="text" />
                <x-input-field name="referral_prize" value="{{ $settings->referral_prize }}" type="number" />

                <div class="col-span-2 mt-4 text-xl font-semibold text-primary-700">
                    Social Links
                </div>
                <x-input-field name="facebook" value="{{ $settings->facebook }}" type="url" />
                <x-input-field name="twitter" value="{{ $settings->twitter }}" type="url" />
                <x-input-field name="discord" value="{{ $settings->discord }}" type="url" />
                <x-input-field name="instagram" value="{{ $settings->instagram }}" type="url" />
                <x-input-field name="telegram_group" value="{{ $settings->telegram_group }}" type="url" />
                <x-input-field name="telegram_channel" value="{{ $settings->telegram_channel }}" type="url" />
                <x-input-field name="youtube" value="{{ $settings->youtube }}" type="url" />
                <x-input-field name="github" value="{{ $settings->github }}" type="url" />
                <x-input-field name="website" value="{{ $settings->website }}" type="url" />
                <x-input-field name="linkedin" value="{{ $settings->linkedin }}" type="url" />
                <x-input-field name="slack" value="{{ $settings->slack }}" type="url" />
                <x-input-field name="reddit" value="{{ $settings->reddit }}" type="url" />
                <x-input-field name="medium" value="{{ $settings->medium }}" type="url" />
                <x-input-field name="white_paper" value="{{ $settings->white_paper }}" type="file" />
                <div class="flex pt-9">
                    @if (\App\Helpers\Cache::settings('white_paper'))
                        <a href='{{ url(\App\Helpers\Cache::settings('white_paper')) }}'>
                            View current uploaded file
                        </a>
                    @endif
                </div>
            </div>

            <button class="mt-6 mb-6 btn btn-primary" type="submit">
                Submit
            </button>
        </form>
    </x-card>
</x-app-layout>
