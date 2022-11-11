@props(['name', 'value', 'checked' => false, 'labelClass' => ''])

<div>
    <input type="radio" id="{{ $name }}_{{ $value }}" name="{{ $name }}"
        value="{{ $value }}" {{ $checked ? 'checked' : '' }} {!! $attributes->merge(['class' => 'hidden peer']) !!}>
    <label for="{{ $name }}_{{ $value }}"
        class="inline-flex justify-between items-center font-semibold uppercase p-5 w-full text-lg text-slate-500
        bg-white dark:bg-slate-900 rounded-lg border-2 border-slate-300 cursor-pointer peer-checked:border-primary-600
        peer-checked:text-primary-600 hover:text-gray-600 hover:bg-gray-100 trasition ease-in-out duration-150 {{ $labelClass }}">
        {{ $slot }}
    </label>
</div>
