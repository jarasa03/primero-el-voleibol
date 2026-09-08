@extends('layouts.public')

@section('title', 'Programa | Primero el Voleibol')
@section('meta_description', 'Programa con medidas concretas para poner orden, formación y feedback en el voleibol madrileño.')
@section('og_image', asset('images/programa-hero.webp'))
@section('body_class', 'page-interior page-programa')

@section('content')
    @php($heroImage = asset('images/programa-hero.webp'))

    <section
        class="relative left-1/2 w-screen -translate-x-1/2 -mt-24 overflow-hidden bg-cover bg-center bg-no-repeat text-white sm:-mt-28 lg:-mt-28"
        style="background-image: url('{{ $heroImage }}');"
    >
        <div class="absolute inset-0 bg-slate-950/35"></div>

        <div class="relative mx-auto max-w-[120rem] px-4 pt-20 pb-10 sm:px-6 sm:pt-[5.5rem] sm:pb-12 lg:px-8 lg:pt-24 lg:pb-14">
            <div class="grid gap-10 lg:grid-cols-[1.25fr_0.75fr] lg:items-center lg:gap-12">
                <div class="flex h-full w-full flex-col justify-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300 sm:text-sm sm:tracking-[0.25em]">Programa</p>
                    <h1 class="mt-2 w-full max-w-none text-4xl font-semibold tracking-tight text-white sm:mt-3 sm:text-5xl lg:text-5xl">
                        Medidas concretas para mejorar el voleibol madrileño
                    </h1>

                    <p class="mt-5 w-full max-w-none text-lg leading-8 text-brand-200 sm:text-xl">
                        Este espacio recoge las propuestas que queremos poner sobre la mesa para mejorar distintos ámbitos del voleibol madrileño. Medidas concretas, realistas y pensadas para responder a problemas que afectan a clubes, árbitros, entrenadores, jugadores y a la propia organización de la competición.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('participa') }}" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300">
                            Aportar una idea
                        </a>
                    </div>
                </div>

                <aside class="lg:justify-self-end">
                    <div class="rounded-[2rem] border border-white/10 bg-white/5 p-5 shadow-[0_12px_30px_rgba(15,23,42,0.18)] backdrop-blur-sm lg:p-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Enfoque</p>
                        <div class="mt-5 space-y-4">
                            <div class="rounded-2xl border border-white/10 bg-slate-900/40 p-4">
                                <p class="text-base font-semibold text-white">Problemas concretos</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Partir de situaciones reales que necesitan una respuesta.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/30 p-4">
                                <p class="text-base font-semibold text-white">Medidas aplicables</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Proponer cambios claros, viables y con una utilidad práctica.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/20 p-4">
                                <p class="text-base font-semibold text-white">Mejora del conjunto</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Trabajar sobre distintos ámbitos para hacer avanzar el voleibol madrileño.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @php($proposalNumber = 1)

    <div data-program-bento class="mt-10 space-y-6 lg:mt-12 lg:columns-2 lg:gap-8 lg:space-y-6">
        @foreach ($programSections as $programSection)
            <section id="{{ $programSection['anchor'] }}" data-program-section class="break-inside-avoid py-4 lg:py-0 lg:mb-6">
                <div class="flex flex-col rounded-[2rem] border border-slate-200 bg-slate-100 px-4 py-5 shadow-sm sm:px-6 lg:px-8 lg:py-6">
                    <div class="max-w-3xl">
                        <h2 data-program-bento-title class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                            {{ $programSection['title'] }}
                        </h2>
                    </div>

                    <div class="mt-4 grid gap-2.5">
                        @forelse ($programSection['items'] as $itemIndex => $item)
                            <details data-program-accordion class="group rounded-[1.5rem] border border-slate-200 bg-white px-5 py-3.5 shadow-sm sm:px-6">
                                <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                                    <div class="flex min-w-0 items-center gap-4">
                                        <span data-program-number="{{ sprintf('%02d', $proposalNumber) }}" class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-slate-50 text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">
                                            {{ sprintf('%02d', $proposalNumber++) }}
                                        </span>
                                        <h3 data-program-bento-title class="min-w-0 text-lg font-semibold tracking-tight text-slate-950 sm:text-xl">
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
                        @empty
                            <p class="rounded-[1.5rem] border border-dashed border-slate-300 bg-white/70 px-5 py-4 text-sm leading-6 text-slate-600 sm:px-6">
                                Aún no hay propuestas publicadas en esta sección.
                            </p>
                        @endforelse
                    </div>

                    @foreach ($programSection['subsections'] ?? [] as $subsection)
                        <div data-program-subsection class="mt-6 rounded-[1.5rem] border border-slate-200 bg-white/70 px-5 py-5 shadow-sm sm:px-6">
                            <div class="max-w-3xl">
                                <h3 data-program-bento-title class="mt-2 text-xl font-semibold tracking-tight text-slate-900 sm:text-2xl">
                                    {{ $subsection['title'] }}
                                </h3>
                            </div>

                            <div class="mt-3 grid gap-2">
                                @forelse ($subsection['items'] as $item)
                                    <details data-program-accordion class="group rounded-[1.25rem] border border-slate-200 bg-slate-50/80 px-4 py-3 shadow-sm sm:px-5">
                                        <summary class="flex cursor-pointer list-none items-center justify-between gap-4">
                                            <div class="flex min-w-0 items-center gap-3">
                                                <span data-program-number="{{ sprintf('%02d', $proposalNumber) }}" class="inline-flex size-8 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                                                    {{ sprintf('%02d', $proposalNumber++) }}
                                                </span>
                                                <h4 data-program-bento-title class="min-w-0 text-sm font-semibold tracking-tight text-slate-900 sm:text-base">
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
                                @empty
                                    <p class="rounded-[1.25rem] border border-dashed border-slate-300 bg-slate-50/80 px-4 py-3 text-sm leading-6 text-slate-600 sm:px-5">
                                        Aún no hay propuestas publicadas en esta sección.
                                    </p>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

    <section class="py-4 lg:py-5">
        <div class="rounded-[2rem] border border-slate-200 bg-slate-100 px-4 py-5 shadow-sm sm:px-6 lg:px-8 lg:py-6">
            <div class="grid gap-6 lg:grid-cols-[1fr_auto] lg:items-center">
                <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Siguiente paso</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Seguiremos ampliando el programa
                    </h2>
                    <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-700">
                        Iremos incorporando nuevas medidas y desarrollando con más detalle las propuestas ya publicadas.
                    </p>
                </div>

                <a href="{{ route('participa') }}" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-slate-800">
                    Aporta una idea
                </a>
            </div>
        </div>
    </section>
@endsection
