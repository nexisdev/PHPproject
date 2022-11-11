<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary uppercase']) }}>
    {{ $slot }}
</button>
