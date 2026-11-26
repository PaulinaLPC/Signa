<a href="{{ route('diccionario.show', $item->slug) }}" class="sign-card">

    <div class="sign-card-media">
        @if ($item->imagen)
            <img src="{{ asset($item->imagen) }}" alt="Seña de {{ $item->palabra }}">
        @else
            <span>{{ $item->categoria->icono }}</span>
        @endif
    </div>

    <div class="sign-card-body">
        <span class="sign-card-category">{{ $item->categoria->nombre }}</span>
        <h3>{{ $item->palabra }}</h3>
    </div>

</a>