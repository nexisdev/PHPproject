<x-app-layout>
    <h1 class="mb-4 text-2xl text-center lg:text-4xl text-primary-700">
        Begin your ID-Verification
    </h1>
    <h4 class="mb-10 text-center text-gray-500 lg:text-lg">
        Verify your identity to participate in token sale.
    </h4>
    <x-card>
        <x-validation-errors class="pb-6 mb-6 border-b" :errors="$errors" />

        <form action="{{ route('kyc.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="flex items-center gap-4">
                <span
                    class="flex items-center justify-center text-xl font-semibold border border-gray-300 rounded-full w-14 h-14 text-primary-500">
                    01
                </span>
                <div>
                    <p class="text-xl font-semibold">
                        Personal Details
                    </p>
                    <p class="text-gray-500">
                        Your simple personal information required for identification
                    </p>
                </div>
            </div>
            <hr class="my-6 -mx-6" />
            <x-help-note class="mb-4">
                Please type carefully and fill out the form with your personal details. Your can’t edit these details
                once you submitted the form.
            </x-help-note>
            <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                <x-input-field name="first_name" type="text" required />
                <x-input-field name="last_name" type="text" required />
                <x-input-field name="phone_number" type="text" />
                <div class="col-span-2 mt-4 text-xl font-semibold text-primary-700">
                    Your Address
                </div>
                <x-input-field name="address_line_1" type="text" required />
                <x-input-field name="address_line_2" type="text" />
                <x-input-field name="city" type="text" required />
                <x-input-field name="state" type="text" required />
                <x-input-field name="zip_code" type="text" required />
            </div>
            <hr class="my-6 -mx-6" />
            <div class="flex items-center gap-6">
                <span
                    class="flex items-center justify-center text-xl font-semibold border border-gray-300 rounded-full w-14 h-14 text-primary-500">
                    02
                </span>
                <div>
                    <p class="text-xl font-semibold">
                        Document Upload
                    </p>
                    <p class="text-gray-500">
                        To verify your identity, please upload any of your document
                    </p>
                </div>
            </div>
            <hr class="my-6 -mx-6" />
            <x-help-note class="mb-6">
                In order to complete, please upload any of the following personal document.
            </x-help-note>
            <div x-data="{ tab: 'passport' }">
                <div class="flex items-center gap-4 mb-6">
                    <x-radio-button checked name="document_type" value="passport" required @click="tab = 'passport'">
                        <div class="flex items-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6"
                                fill="currentColor">
                                <path
                                    d="M0 64C0 28.7 28.7 0 64 0H384c35.3 0 64 28.7 64 64V448c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V64zM183 278.8c-27.9-13.2-48.4-39.4-53.7-70.8h39.1c1.6 30.4 7.7 53.8 14.6 70.8zm41.3 9.2l-.3 0-.3 0c-2.4-3.5-5.7-8.9-9.1-16.5c-6-13.6-12.4-34.3-14.2-63.5h47.1c-1.8 29.2-8.1 49.9-14.2 63.5c-3.4 7.6-6.7 13-9.1 16.5zm40.7-9.2c6.8-17.1 12.9-40.4 14.6-70.8h39.1c-5.3 31.4-25.8 57.6-53.7 70.8zM279.6 176c-1.6-30.4-7.7-53.8-14.6-70.8c27.9 13.2 48.4 39.4 53.7 70.8H279.6zM223.7 96l.3 0 .3 0c2.4 3.5 5.7 8.9 9.1 16.5c6 13.6 12.4 34.3 14.2 63.5H200.5c1.8-29.2 8.1-49.9 14.2-63.5c3.4-7.6 6.7-13 9.1-16.5zM183 105.2c-6.8 17.1-12.9 40.4-14.6 70.8H129.3c5.3-31.4 25.8-57.6 53.7-70.8zM352 192c0-70.7-57.3-128-128-128S96 121.3 96 192s57.3 128 128 128s128-57.3 128-128zM112 384c-8.8 0-16 7.2-16 16s7.2 16 16 16H336c8.8 0 16-7.2 16-16s-7.2-16-16-16H112z" />
                            </svg>
                            <span>PASSPORT</span>
                        </div>
                    </x-radio-button>
                    <x-radio-button name="document_type" value="national_card" required @click="tab = 'national_card'">
                        <div class="flex flex-col items-center gap-4 lg:flex-row">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6"
                                fill="currentColor">
                                <path
                                    d="M0 96l576 0c0-35.3-28.7-64-64-64H64C28.7 32 0 60.7 0 96zm0 32V416c0 35.3 28.7 64 64 64H512c35.3 0 64-28.7 64-64V128H0zM64 405.3c0-29.5 23.9-53.3 53.3-53.3H234.7c29.5 0 53.3 23.9 53.3 53.3c0 5.9-4.8 10.7-10.7 10.7H74.7c-5.9 0-10.7-4.8-10.7-10.7zM176 320c-35.3 0-64-28.7-64-64s28.7-64 64-64s64 28.7 64 64s-28.7 64-64 64zM352 208c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16zm0 64c0-8.8 7.2-16 16-16H496c8.8 0 16 7.2 16 16s-7.2 16-16 16H368c-8.8 0-16-7.2-16-16z" />
                            </svg>
                            <span>NATIONAL CARD</span>
                        </div>
                    </x-radio-button>
                    <x-radio-button name="document_type" value="driver_license" required
                        @click="tab = 'driver_license'">
                        <div class="flex items-center gap-4">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6"
                                fill="currentColor">
                                <path
                                    d="M135.2 117.4L109.1 192H402.9l-26.1-74.6C372.3 104.6 360.2 96 346.6 96H165.4c-13.6 0-25.7 8.6-30.2 21.4zM39.6 196.8L74.8 96.3C88.3 57.8 124.6 32 165.4 32H346.6c40.8 0 77.1 25.8 90.6 64.3l35.2 100.5c23.2 9.6 39.6 32.5 39.6 59.2V400v48c0 17.7-14.3 32-32 32H448c-17.7 0-32-14.3-32-32V400H96v48c0 17.7-14.3 32-32 32H32c-17.7 0-32-14.3-32-32V400 256c0-26.7 16.4-49.6 39.6-59.2zM128 288c0-17.7-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32s32-14.3 32-32zm288 32c17.7 0 32-14.3 32-32s-14.3-32-32-32s-32 14.3-32 32s14.3 32 32 32z" />
                            </svg>
                            <span>DRIVER'S LICENSE</span>
                        </div>
                    </x-radio-button>
                </div>
                <p class="mb-4 text-lg font-semibold text-primary-700">
                    To avoid delays when verifying account, Please make sure bellow:
                </p>
                <ul class="mb-2 leading-loose list-disc list-inside text-slate-600">
                    <li>Chosen credential must not be expaired.</li>
                    <li>Document should be good condition and clearly visible.</li>
                    <li>Make sure that there is no light glare on the card.</li>
                </ul>
                <template x-if="tab === 'passport'">
                    <div class="py-4 rounded-lg" role="tabpanel">
                        <p class="mb-4 text-lg font-semibold text-primary-700">
                            Upload Here Your Passport Copy
                        </p>
                        <x-dropzone class="max-w-xl" name="document_front_side" accept="image/*" />
                    </div>
                </template>
                <template x-if="tab === 'national_card'">
                    <div class="py-4 rounded-lg" role="tabpanel">
                        <p class="mb-4 text-lg font-semibold text-primary-700">
                            Upload Here Your National id Front Side
                        </p>
                        <x-dropzone class="max-w-xl mb-6" name="document_front_side" accept="image/*" />
                        <p class="mb-4 text-lg font-semibold text-primary-700">
                            Upload Here Your National id Back Side
                        </p>
                        <x-dropzone class="max-w-xl" name="document_back_side" accept="image/*" />
                    </div>
                </template>
                <template x-if="tab === 'driver_license'">
                    <div class="py-4 rounded-lg" role="tabpanel">
                        <p class="mb-4 text-lg font-semibold text-primary-700">
                            Upload Here Your Driving Licence Copy
                        </p>
                        <x-dropzone class="max-w-xl mb-4" name="document_front_side" accept="image/*" />
                    </div>
                </template>
            </div>
            <hr class="my-6 -mx-6" />
            <div class="flex items-center gap-6">
                <span
                    class="flex items-center justify-center text-xl font-semibold border border-gray-300 rounded-full w-14 h-14 text-primary-500">
                    03
                </span>
                <div>
                    <p class="text-xl font-semibold">
                        Your Paying Wallet
                    </p>
                    <p class="text-gray-500">
                        Submit your wallet address that you are going to send funds
                    </p>
                </div>
            </div>
            <hr class="my-6 -mx-6" />
            <div class="flex flex-col gap-6">
                <x-input-field label="Your Address for tokens" name="wallet_address" required
                    description="Note: Address should be ERC20-compliant." />
            </div>
            <hr class="my-6 -mx-6" />
            <div class="flex flex-col gap-6 mb-6">
                <x-checkbox name="agree" required>
                    I Have Read The Terms Of Condition And Privary Policy.
                </x-checkbox>
                <x-checkbox name="confirm" required>
                    All The Personal Information I Have Entered Is Correct.
                </x-checkbox>
            </div>

            <button class="mb-6 btn btn-primary" type="submit">
                Process for verify
            </button>
        </form>
    </x-card>
</x-app-layout>
