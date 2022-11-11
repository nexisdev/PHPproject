@props(['value', 'name', 'label'])

<div class="flex items-center">
    <input id="{{ $value ?? $name }}" name="{{ $name }}" type="checkbox" @checked(old($name))
        {!! $attributes !!}
        class="w-4 h-4 bg-gray-100 border-gray-300 rounded cursor-pointer text-primary-600 focus:ring-primary-500 focus:ring-2">
    <label for="{{ $value ?? $name }}" class="ml-2 text-sm font-medium text-gray-900 dark:text-white cursor-pointer">
        {{ $slot }}
    </label>
</div>
