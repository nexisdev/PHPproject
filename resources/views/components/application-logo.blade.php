@php
$logo = \App\Helpers\Cache::settings('logo') ? Storage::url(\App\Helpers\Cache::settings('logo')) : asset('images/logo.png');
$project_name = \App\Helpers\Cache::settings('project_name') ?? '';
@endphp
<div class="flex items-center text-blue-700 dark:text-white text-2xl font-bold">
    <img src="{{ $logo }}" {{ $attributes->merge(['class' => 'h-6 mr-3 sm:h-14']) }} alt="Logo">
    <span>{{ $project_name }}</span>
</div>
