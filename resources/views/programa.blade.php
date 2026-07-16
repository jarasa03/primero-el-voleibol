@extends('layouts.public')

@section('title', 'Programa')
@section('meta_description', 'Programa con medidas concretas para poner orden, formación y feedback en el voleibol madrileño.')
@section('body_class', 'page-interior page-programa')

@section('content')
    @php($heroImage = asset('images/programa-hero.webp'))

    <section
        class="relative left-1/2 w-screen -translate-x-1/2 -mt-24 overflow-hidden bg-cover bg-center bg-no-repeat text-white sm:-mt-28 lg:-mt-28"
        style="background-image: url('{{ $heroImage }}');"
    >
        <div class="absolute inset-0 bg-slate-950/35"></div>

        <div class="relative mx-auto max-w-7xl px-4 pt-20 pb-10 sm:px-6 sm:pt-[5.5rem] sm:pb-12 lg:px-8 lg:pt-24 lg:pb-14">
            <div class="grid gap-10 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:gap-12">
                <div class="flex h-full max-w-3xl flex-col justify-center">
                    <h1 class="max-w-2xl text-4xl font-semibold tracking-tight text-white sm:text-5xl lg:text-5xl">
                        Medidas concretas para mejorar el voleibol madrileño
                    </h1>

                    <p class="mt-5 max-w-2xl text-lg leading-8 text-brand-200 sm:text-xl">
                        Este espacio recoge propuestas que queremos poner sobre la mesa. Arrancamos con varias ideas
                        claras: sanciones con consecuencias reales, formación anual para árbitros y feedback continuo
                        entre distintos niveles de arbitraje.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="#clubes" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300">
                            Ver contenido
                        </a>
                        <a href="{{ route('contacto') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-white/10">
                            Aportar una idea
                        </a>
                    </div>
                </div>

                <aside class="lg:justify-self-end">
                    <div class="rounded-[2rem] border border-white/10 bg-white/5 p-5 shadow-[0_12px_30px_rgba(15,23,42,0.18)] backdrop-blur-sm lg:p-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Enfoque</p>
                        <div class="mt-5 space-y-4">
                            <div class="rounded-2xl border border-white/10 bg-slate-900/40 p-4">
                                <p class="text-base font-semibold text-white">Orden</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Hacer que las tarjetas tengan consecuencias reales y claras.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/30 p-4">
                                <p class="text-base font-semibold text-white">Formación</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Alinear criterios y preparar mejor la temporada desde el inicio.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/20 p-4">
                                <p class="text-base font-semibold text-white">Mejora continua</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Crear una cultura de feedback constante entre niveles de arbitraje.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @php($proposalNumber = 1)

    @foreach ($programSections as $programSection)
        <section id="{{ $programSection['anchor'] }}" data-program-section class="py-4 lg:py-5">
            <div class="rounded-[2rem] border border-slate-200 bg-slate-100 px-6 py-5 shadow-sm sm:px-8 lg:px-10 lg:py-6">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">{{ $programSection['eyebrow'] }}</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        {{ $programSection['title'] }}
                    </h2>
                </div>

                <div class="mt-4 grid gap-2.5">
                    @foreach ($programSection['items'] as $itemIndex => $item)
                        <details data-program-accordion class="group rounded-[1.5rem] border border-slate-200 bg-white px-5 py-3.5 shadow-sm sm:px-6">
                            <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                                <div class="flex min-w-0 items-center gap-4">
                                    <span data-program-number="{{ sprintf('%02d', $proposalNumber) }}" class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">
                                        {{ sprintf('%02d', $proposalNumber++) }}
                                    </span>
                                    <h3 class="min-w-0 text-lg font-semibold tracking-tight text-slate-950 sm:text-xl">
                                        {{ $item['title'] }}
                                    </h3>
                                </div>

                                <span class="inline-flex size-11 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-xl font-semibold leading-none text-slate-700 transition group-open:rotate-45">
                                    +
                                </span>
                            </summary>

                            <div data-program-panel class="overflow-hidden transition-[max-height,opacity] duration-300 ease-in-out">
                                <div class="mt-3.5 border-t border-slate-200 pt-3.5 text-[1rem] leading-7 text-slate-700">
                                    {!! str($item['details'])->sanitizeHtml() !!}
                                </div>
                            </div>
                        </details>
                    @endforeach
                </div>

                @foreach ($programSection['subsections'] ?? [] as $subsection)
                    <div data-program-subsection class="mt-6 rounded-[1.5rem] border border-slate-200 bg-white/70 px-5 py-5 shadow-sm sm:px-6">
                        <div class="max-w-3xl">
                            @if (! empty($subsection['eyebrow']))
                                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-slate-500">
                                    {{ $subsection['eyebrow'] }}
                                </p>
                            @endif
                            <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">
                                {{ $subsection['title'] }}
                            </h3>
                        </div>

                        <div class="mt-3 grid gap-2">
                            @foreach ($subsection['items'] as $item)
                                <details data-program-accordion class="group rounded-[1.25rem] border border-slate-200 bg-slate-50/80 px-4 py-3 shadow-sm sm:px-5">
                                    <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                                        <div class="flex min-w-0 items-center gap-3">
                                            <span data-program-number="{{ sprintf('%02d', $proposalNumber) }}" class="inline-flex size-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                                                {{ sprintf('%02d', $proposalNumber++) }}
                                            </span>
                                            <h4 class="min-w-0 text-sm font-semibold tracking-tight text-slate-900 sm:text-base">
                                                {{ $item['title'] }}
                                            </h4>
                                        </div>

                                        <span class="inline-flex size-9 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-base font-semibold leading-none text-slate-500 transition group-open:rotate-45">
                                            +
                                        </span>
                                    </summary>

                                    <div data-program-panel class="overflow-hidden transition-[max-height,opacity] duration-300 ease-in-out">
                                        <div class="mt-3 border-t border-slate-200 pt-3 text-sm leading-7 text-slate-600">
                                            {!! str($item['details'])->sanitizeHtml() !!}
                                        </div>
                                    </div>
                                </details>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endforeach

    <section class="py-4 lg:py-5">
        <div class="rounded-[2rem] border border-slate-200 bg-slate-100 px-6 py-5 shadow-sm sm:px-8 lg:px-10 lg:py-6">
            <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Siguiente paso</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Seguiremos ampliando el programa
                    </h2>
                    <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-700">
                        Queremos que este apartado crezca con más propuestas, más detalle y más debate compartido.
                    </p>
                </div>

                <a href="{{ route('contacto') }}" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-slate-800">
                    Escríbenos
                </a>
            </div>
        </div>
    </section>
@endsection
