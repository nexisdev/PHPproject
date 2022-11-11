@props(['type' => 'info'])

@php
$classType = [
    'info' => 'border-blue-400 text-blue-400',
    'success' => 'border-green-400 text-green-400',
    'danger' => 'border-red-400 text-red-400',
];
@endphp

<div {!! $attributes->merge([
    'class' => 'flex flex-col justify-center items-center text-center max-w-lg mx-auto',
]) !!}>
    <div
        class="border-2 border-solid {{ $classType[$type] }} mb-6 rounded-full w-24 h-24 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-12 h-12">
            @if ($type == 'info')
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            @elseif ($type == 'success')
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            @elseif ($type == 'danger')
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            @endif
        </svg>
    </div>
    {{ $slot }}
</div>
