@if (Session::has('success') || Session::has('error'))
    @php
        $alert_color = '';
        $alert_message = '';
        $alert_title = '';

        if (Session::has('success')) {
            $alert_color = 'text-green-700 bg-green-100';
            $alert_title = 'Success';
            $alert_message = session('success');
        } elseif (Session::has('error')) {
            $alert_color = 'text-red-700 bg-red-100';
            $alert_title = 'Error';
            $alert_message = session('error');
        }
    @endphp
    <div {!! $attributes->merge(['class' => $alert_color]) !!} role="alert">
        <div class="flex p-4 text-sm max-w-6xl px-5 mx-auto">
            <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd"></path>
            </svg>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-semibold">{{ $alert_title }}</span> {{ $alert_message }}
            </div>
        </div>
    </div>
@endif
