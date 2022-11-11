<tr>
    @php
        $logo = \App\Helpers\Cache::settings('logo') ? Storage::url(\App\Helpers\Cache::settings('logo')) : asset('images/logo.png');
    @endphp
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            <img src="{{ $logo }}" class="logo" alt="{{ config('app.name') }} Logo">
        </a>
    </td>
</tr>
