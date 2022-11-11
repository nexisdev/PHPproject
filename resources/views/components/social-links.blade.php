@props(['links'])

<div {{ $attributes->merge(['class' => 'flex flex-wrap gap-2']) }}>
    @foreach ($links as $key => $link)
        @if ($link)
            <a href="{{ $link }}" target="_blank"
                class="flex items-center justify-center w-6 h-6 p-4 rounded-full bg-primary-600 hover:bg-primary-900">
                <i class="fa-brands fa-{{ $key }} text-white"></i>
            </a>
        @endif
    @endforeach
</div>
