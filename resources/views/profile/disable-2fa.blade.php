<x-app-layout>
    <x-card title="Enable Two-Factor Verification">
        <x-validation-errors class="mb-6" :errors="$errors" />
        <x-session-status class="mb-6" />
        <form action="{{ route('profile.enable-2fa.store') }}" method="POST">
            @csrf
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
