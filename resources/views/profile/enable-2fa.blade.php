<x-app-layout>
    <x-card title="Enable Two-Factor Verification">
        <x-validation-errors class="mb-6" :errors="$errors" />
        <x-session-status class="mb-6" />
        <form action="{{ route('profile.enable-2fa.store') }}" method="POST">
            @csrf
            <input type="hidden" name="secret" value="{{ $secret }}">
            <div class="flex flex-col divide-y divide-gray-100 dark:divide-gray-600">
                <p class="py-4">
                    <span>
                        1. <b>Get the Authenticator app</b> From
                    </span>
                    <a class="text-primary-500 font-semibold hover:text-primary-700" target="_blank"
                        href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&amp;hl=en">
                        Play Store
                    </a>
                    or
                    <a class="text-primary-500 font-semibold hover:text-primary-700" target="_blank"
                        href="https://itunes.apple.com/si/app/google-authenticator/id388497605?mt=8"> App
                        Store
                    </a>.
                </p>
                <p class="py-4">
                    2. In the application, press the plus button (+).
                </p>
                <div class="py-4">
                    <p class="mb-4">3. Choose Scan QR Code.</p>
                    {!! $qr_code_image !!}
                </div>
                <div class="py-4">
                    <p class="mb-4">4. Enter the 6-digit 2FA security code.</p>
                    <x-input-field name="one_time_password" placeholder="6 digit 2FA security code" type="text"
                        pattern="[0-9]{6}" required />
                </div>
            </div>
            <div class="flex items-center gap-2 my-6">
                <x-button> Enable 2FA </x-button>
                <a href="{{ route('profile.index') }}" class="btn btn-secondary-alt">
                    Back
                </a>
            </div>
        </form>

    </x-card>
</x-app-layout>
