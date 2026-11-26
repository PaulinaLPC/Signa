@if ($sena?->youtube_id)

    <div class="sign-video-embed">
        <iframe
            src="https://www.youtube-nocookie.com/embed/{{ $sena->youtube_id }}?rel=0"
            title="Video de la seña"
            allow="accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen
        ></iframe>
    </div>

@elseif ($sena?->video_url)

    <video src="{{ $sena->video_url }}" controls loop playsinline preload="metadata"></video>

@elseif ($sena?->imagen_url)

    <img src="{{ $sena->imagen_url }}" alt="Seña a identificar">

@else

    <div class="sign-media-empty">
        <span>🎬</span>
        <p>Esta seña todavía no tiene video.</p>
    </div>

@endif