@props(['id', 'name', 'label', 'description', 'value', 'options', 'disabled' => false])
<div>
    <label for="{{ $id ?? $name }}" class="form-label">
        {{ $label ?? Str::ucfirst(Str::replace('_', ' ', $name)) }}
        @if (isset($attributes['required']))
            <span class="text-red-500">*</span>
        @endif
    </label>
    <select id="{{ $id ?? $name }}" {!! $attributes->merge(['class' => 'form-control', 'value' => old($name)]) !!} name="{{ $name }}">
        @if (isset($options) && is_array($options))
            @foreach ($options as $key => $item)
                <option value="{{ $key }}" @selected(($value ?? old($name)) == $key)>{{ $item }}</option>
            @endforeach
        @else
            {{ $slot }}
        @endif
    </select>
    @if (isset($description))
        <div class="mt-1 text-sm text-gray-500 dark:text-gray-200">{{ $description }}</div>
    @endif
</div>
