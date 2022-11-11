 @php
     $isEdit = $type == 'edit';
 @endphp
 <form x-data action="{{ $isEdit ? route('payable-tokens.update', $item) : route('payable-tokens.store') }}"
     @submit.prevent="{{ $isEdit ? 'e => e.target.submit()' : '$store.wallet.addNewToken($event)' }}" method="POST"
     enctype="multipart/form-data">
     @csrf

     @if ($isEdit)
         @method('PUT')
     @else
         <div class="mb-6">
             <x-wallet-connect-button />
         </div>
     @endif

     <x-loader x-show="$store.wallet.loading" />

     <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
         <div class="col-span-3">
             <x-input-field name="contract_address" type="text" required value="{{ $item?->contract_address }}"
                 pattern="^0x[a-fA-F0-9]{40}$" :disabled="$isEdit"
                 description="Contract address must start with 0x and have 42 chars" />
         </div>
         <x-input-field name="symbol" type="text" required value="{{ $item?->symbol }}" pattern="^[a-zA-Z0-9]{1,5}$"
             description="Symbol must not be more than 5 chars" />
         <x-input-field name="name" type="text" required value="{{ $item?->name }}" />
         <x-input-field name="decimals" type="number" :disabled="$isEdit" value="{{ $item?->decimals }}" />
         <label for="status" class="relative inline-flex items-center mt-2 cursor-pointer">
             <input type="checkbox" @checked(old('status') ?? ($item?->status ?? true)) id="status" name="status" class="sr-only peer">
             <div
                 class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-primary-300 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600">
             </div>
             <span class="ml-3 text-sm font-medium text-gray-900 dark:text-white">Active Token</span>
         </label>
         <div class="col-span-3 py-4 rounded-lg" role="tabpanel">
             <p class="mb-4 text-lg font-semibold text-primary-700">
                 Upload Token Image
             </p>
             <x-dropzone class="max-w-xl mb-4" name="image" accept="image/*" :required="!$isEdit" />
         </div>
     </div>

     <div class="flex items-center gap-2 mb-6">
         <button class="btn btn-primary" type="submit">
             Submit
         </button>
         <a href="{{ route('payable-tokens.index') }}" class="btn btn-secondary-alt">
             Back
         </a>
     </div>
 </form>
