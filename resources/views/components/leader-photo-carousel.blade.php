@props([
    'photos' => [],
    'interval' => 5000,
    'ariaLabel' => 'Carrusel de fotos del líder',
])

<div
    {{ $attributes->class('leader-photo-carousel') }}
    data-leader-carousel
    data-leader-carousel-interval="{{ $interval }}"
    aria-label="{{ $ariaLabel }}"
>
    <div class="leader-photo-carousel__frame">
        @foreach ($photos as $photo)
            <div class="leader-photo-carousel__slide" data-leader-slide @if ($loop->first) data-active="true" @endif>
                <img
                    src="{{ $photo['image'] }}"
                    alt="{{ $photo['alt'] ?? $photo['name'] ?? 'Foto del líder' }}"
                    class="leader-photo-carousel__image"
                    loading="lazy"
                >
            </div>
        @endforeach
    </div>
</div>
