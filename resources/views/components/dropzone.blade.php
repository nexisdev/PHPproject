@props(['name', 'accept' => '*', 'required' => false])

<div {!! $attributes->merge(['class' => 'flex justify-center items-center relative']) !!}>
    <label x-data="dropzone" for="{{ $name }}"
        class="flex flex-col items-center justify-center w-full h-64 transition-all duration-300 bg-gray-200 border-2 border-gray-400 border-dashed rounded-lg cursor-pointer dark:border-gray-600 dark:bg-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
        <div class="p-6 overflow-hidden">
            <template x-if="!previewUrl">
                <div class="flex flex-col items-center justify-center text-gray-500 dark:text-gray-200">
                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                        </path>
                    </svg>
                    <p class="mb-2 text-sm">
                        <span class="font-semibold"> Click to upload</span> or drag and drop
                    </p>
                    <p class="text-xs">SVG, PNG, JPG</p>
                </div>
            </template>
            <template x-if="previewUrl">
                <div class="flex flex-col items-center justify-center">
                    <figure class="max-w-lg text-center">
                        <img class="object-contain h-40 max-w-full overflow-hidden rounded-lg w-h-40"
                            :src="previewUrl" :alt="files[0].name">
                        <figcaption class="mt-2 text-sm text-center text-gray-500 dark:text-gray-200"
                            x-text="files[0].name"></figcaption>
                    </figure>
                </div>
            </template>
        </div>
        <input id="{{ $name }}" name="{{ $name }}" type="file" {{ $required ? 'required' : '' }}
            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" accept="{{ $accept }}"
            @change="updatePreview" />
    </label>
</div>
