@props(['type' => 'primary'])
@php
$classes = [
    'primary' => 'bg-primary-100 text-primary-800',
    'secondary' => 'bg-gray-100 text-gray-800',
    'danger' => 'bg-red-100 text-red-800',
    'success' => 'bg-green-100 text-green-800',
    'warning' => 'bg-yellow-100 text-yellow-800',
];
@endphp
<span {!! $attributes->merge([
    'class' => $classes[$type] . ' capitalize text-xs font-semibold mr-2 px-2.5 py-0.5 rounded',
]) !!}>
    {{ $slot }}
</span>
