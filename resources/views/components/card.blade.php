@props(['title'])

<div {!! $attributes->merge([
    'class' =>
        'relative overflow-hidden bg-white dark:bg-slate-900 shadow-lg sm:rounded-lg border border-gray-200 dark:border-gray-700',
]) !!}>
    @if (isset($title))
        <div class="px-6 py-4 bg-white border-b border-gray-200 dark:bg-slate-900 dark:border-gray-600">
            <div class="text-xl font-semibold">{{ $title }}</div>
        </div>
    @endif
    <div class="px-6 py-4">
        {{ $slot }}
    </div>
</div>
