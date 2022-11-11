@props(['id', 'name', 'label', 'description', 'append', 'disabled' => false, 'changes'])

@php
$inputClass = (isset($append) ? '!rounded-r-none' : '') . ' form-control';
@endphp

<div>
    <label for="{{ $id ?? $name }}" class="form-label">
        {{ $label ?? Str::ucfirst(Str::replace('_', ' ', $name)) }}
        @if (isset($attributes['required']))
            <span class="text-red-500">*</span>
        @endif
    </label>
    <div class="flex">
        <input id="{{ $id ?? $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
            'class' => $inputClass,
            'value' => old($name),
        ]) !!}
            name="{{ $name }}" />
        @if (isset($append))
            <span
                class="inline-flex items-center px-3 text-sm text-gray-900 bg-gray-200 border border-l-0 border-gray-300 whitespace-nowrap dark:text-white dark:bg-gray-600 rounded-r-md dark:border-gray-700">
                {{ $append }}
            </span>
        @endif
    </div>
    @if (isset($description))
        <div class="mt-1 text-sm text-gray-500 dark:text-gray-200">{{ $description }}</div>
    @endif
</div>
