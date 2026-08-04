@props([
    'items' => [],
    'mode' => 'logos',
    'direction' => 'left',
    'duration' => 42,
    'speed' => 50,
    'gap' => 1.25,
    'fadeColor' => '#ffffff',
    'startOffset' => '0%',
    'ariaLabel' => 'Carrusel continuo',
    'fullWidth' => true,
    'imageFit' => 'contain',
    'autofillMultiplier' => 1.35,
])

@php
    $isCards = $mode === 'cards';
    $isImages = $mode === 'images';
    $isLogoMarquee = $mode === 'logos';
    $isCoverImageFit = $imageFit === 'cover';
    $baseItems = is_array($items) ? $items : collect($items)->all();
    $renderItems = $baseItems;

    $trackDirectionClass = $direction === 'right' ? 'marquee-track--reverse' : '';
@endphp

<div
    {{ $attributes->class(['marquee-viewport', 'marquee-viewport--contained' => ! $fullWidth]) }}
    role="region"
    aria-label="{{ $ariaLabel }}"
    data-marquee-mode="{{ $mode }}"
    data-marquee-direction="{{ $direction }}"
    data-marquee-autofill="{{ $isCards || $isImages ? 'false' : 'true' }}"
    data-marquee-autofill-multiplier="{{ $autofillMultiplier }}"
    data-marquee-speed="{{ $speed }}"
    style="--marquee-duration: {{ $duration }}s; --marquee-gap: {{ $gap }}rem; --marquee-fade-color: {{ $fadeColor }}; --marquee-start-offset: {{ $startOffset }};"
>
    <div class="marquee-fade marquee-fade--start" aria-hidden="true"></div>
    <div class="marquee-fade marquee-fade--end" aria-hidden="true"></div>

    <div class="marquee-track {{ $trackDirectionClass }}">
        @foreach ([$items, $items] as $groupIndex => $groupItems)
            <div class="marquee-group" @if ($groupIndex === 1) aria-hidden="true" @endif>
                @foreach ($renderItems as $item)
                    @if ($isImages)
                        @php
                            $image = is_array($item) ? ($item['image'] ?? null) : $item;
                            $alt = is_array($item) ? ($item['alt'] ?? ($item['name'] ?? 'Imagen')) : 'Imagen';
                            $fallbackInitials = is_array($item) ? ($item['initials'] ?? 'PV') : 'PV';
                            $fallbackClass = is_array($item) ? ($item['backgroundClass'] ?? 'from-brand-950 via-slate-900 to-slate-700') : 'from-brand-950 via-slate-900 to-slate-700';
                        @endphp

                        <article class="marquee-image-card">
                            <div class="marquee-image-card__media">
                                @if (! empty($image))
                                    <img
                                        src="{{ $image }}"
                                        alt="{{ $alt }}"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="marquee-image-card__fallback bg-gradient-to-br {{ $fallbackClass }}">
                                        <span class="marquee-image-card__initials">{{ $fallbackInitials }}</span>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @elseif ($isCards)
                        <article class="marquee-referee-card">
                            <div class="marquee-referee-card__media">
                                @if (! empty($item['image']))
                                    <img
                                        src="{{ $item['image'] }}"
                                        alt="{{ $item['name'] }}"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="marquee-referee-card__fallback bg-gradient-to-br {{ $item['backgroundClass'] ?? 'from-brand-950 via-slate-900 to-slate-700' }}">
                                        <span class="marquee-referee-card__initials">{{ $item['initials'] ?? 'PV' }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-5 sm:p-6">
                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">
                                    {{ $item['label'] ?? 'Árbitro' }}
                                </p>
                                <h3 class="mt-3 text-lg font-semibold tracking-tight text-slate-950">
                                    {{ $item['name'] }}
                                </h3>
                                <p class="mt-2 text-sm leading-6 text-slate-600">
                                    {{ $item['title'] }}
                                </p>
                                @if (! empty($item['description']))
                                    <p class="mt-3 text-sm leading-6 text-slate-500">
                                        {{ $item['description'] }}
                                    </p>
                                @endif
                            </div>
                        </article>
                    @else
                        @php
                            $image = is_array($item) ? ($item['image'] ?? null) : null;
                            $description = is_array($item) ? ($item['description'] ?? ($item['label'] ?? null)) : null;
                            $fallbackInitials = is_array($item) ? ($item['initials'] ?? 'PV') : 'PV';
                            $fallbackClass = is_array($item) ? ($item['badgeClass'] ?? 'from-brand-950 via-slate-900 to-slate-700') : 'from-brand-950 via-slate-900 to-slate-700';
                        @endphp

                        <article class="marquee-logo-card {{ $isCoverImageFit ? 'marquee-logo-card--cover' : '' }}">
                            <div class="marquee-logo-card__media {{ $isCoverImageFit ? 'marquee-logo-card__media--cover' : '' }}">
                                @if (! empty($image))
                                    <img
                                        src="{{ $image }}"
                                        alt="{{ $item['name'] }}"
                                        class="marquee-logo-card__image {{ $isCoverImageFit ? 'marquee-logo-card__image--cover' : '' }}"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="marquee-logo-card__fallback bg-gradient-to-br {{ $fallbackClass }} {{ $isCoverImageFit ? 'marquee-logo-card__fallback--cover' : '' }}">
                                        <span class="marquee-logo-card__initials">{{ $fallbackInitials }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="marquee-logo-card__content">
                                <p class="marquee-logo-card__eyebrow">
                                    {{ $item['label'] ?? 'Club colaborador' }}
                                </p>

                                <h3 class="marquee-logo-card__title">
                                    {{ $item['name'] }}
                                </h3>

                                @if (! empty($description))
                                    <p class="marquee-logo-card__description">
                                        {{ $description }}
                                    </p>
                                @endif

                                <div class="marquee-logo-card__footer">
                                    <span class="size-2 rounded-full bg-amber-400"></span>
                                    En apoyo del proyecto
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
</div>
