@extends('layouts.public')

@section('title', 'Proyecto')
@section('meta_description', 'Conoce quién lidera Primero el Voleibol, los clubes y árbitros que apoyan la iniciativa, y la propuesta arbitral para la Asamblea de Madrid.')
@section('body_class', 'page-interior page-proyecto')

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
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300 sm:text-sm sm:tracking-[0.25em]">Proyecto</p>
                    <h1 class="mt-2 w-full max-w-none text-4xl font-semibold tracking-tight text-white sm:mt-3 sm:text-5xl lg:text-5xl">
                        Quién lidera, quién apoya y quién representa
                    </h1>

                    <p class="mt-5 w-full max-w-none text-lg leading-8 text-brand-200 sm:text-xl">
                        En esta página dejamos clara la estructura del proyecto: una persona que lo impulsa,
                        clubes que lo respaldan, árbitros que suman criterio y una propuesta concreta para la
                        Asamblea de Madrid.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="#contenido" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300">
                            Ver contenido
                        </a>
                        <a href="{{ route('participa') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-white/10">
                            Aportar una idea
                        </a>
                    </div>
                </div>

                <aside class="lg:justify-self-end">
                    <div class="rounded-[2rem] border border-white/10 bg-white/5 p-5 shadow-[0_12px_30px_rgba(15,23,42,0.18)] backdrop-blur-sm lg:p-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">La idea</p>
                        <div class="mt-5 space-y-4">
                            <div class="rounded-2xl border border-white/10 bg-slate-900/40 p-4">
                                <p class="text-base font-semibold text-white">Visibilidad</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    La persona que lidera el proyecto debe aparecer con claridad y sin ambigüedades.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/30 p-4">
                                <p class="text-base font-semibold text-white">Apoyos reales</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Queremos que clubes y árbitros tengan un espacio visual fuerte y memorable.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/20 p-4">
                                <p class="text-base font-semibold text-white">Representación</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Los tres árbitros propuestos deben quedar presentados como una apuesta clara de futuro.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <div class="mx-auto w-full max-w-[120rem] px-4 sm:px-6 lg:px-8">
        @if ($projectLeader['show_leader_section'])
            <section id="contenido" class="py-10 lg:py-14">
                <div class="grid gap-6 lg:grid-cols-[0.82fr_1.18fr] lg:items-start">
                <article class="max-w-3xl rounded-[2rem] border border-slate-200 bg-white px-4 py-6 shadow-sm sm:px-5 lg:px-6 lg:py-7">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Liderazgo</p>
                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl">
                        Quién lidera el proyecto
                    </h2>

                    <div class="mt-5 overflow-hidden rounded-[1.75rem] border border-slate-200 bg-white shadow-[0_10px_30px_rgba(15,23,42,0.05)]">
                        <x-leader-photo-carousel :photos="$projectLeader['photos']" />

                        <div class="border-t border-slate-200 bg-white p-4 sm:p-5">
                            <p class="text-[0.7rem] font-semibold uppercase tracking-[0.28em] text-slate-600">
                                {{ $projectLeader['role'] }}
                            </p>
                            <h3 class="mt-1.5 text-xl font-semibold tracking-tight text-slate-950 sm:text-2xl">
                                {{ $projectLeader['name'] }}
                            </h3>
                            <p class="mt-3 text-sm leading-6 text-slate-700">
                                {{ $projectLeader['description'] }}
                            </p>
                        </div>
                    </div>
                </article>

                <div class="grid gap-4 sm:grid-cols-3 lg:grid-cols-1">
                    <div class="hidden rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6 shadow-sm lg:block">
                        <p class="text-sm font-semibold uppercase tracking-[0.24em] text-slate-500">Perfil</p>
                        <div class="mt-4 space-y-3">
                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-accent-700">Trayectoria</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">Árbitro internacional con recorrido en la élite.</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-accent-700">Superliga 1</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">638 partidos pitados en la máxima referencia nacional.</p>
                            </div>
                            <div class="rounded-2xl border border-slate-200 bg-white px-4 py-3">
                                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-accent-700">Formación</p>
                                <p class="mt-1 text-sm leading-6 text-slate-700">Entrenador FIVB 2 y referente de criterio arbitral.</p>
                            </div>
                        </div>
                    </div>

                    @foreach ($projectSupporters as $supporter)
                        <article class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6 shadow-sm">
                            <div class="flex items-start gap-4">
                                <div class="grid size-12 shrink-0 place-items-center rounded-2xl bg-slate-950 text-xs font-semibold tracking-[0.24em] text-white">
                                    {{ $supporter['initials'] }}
                                </div>

                                <div class="min-w-0">
                                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">
                                        {{ $supporter['role'] }}
                                    </p>
                                    <h3 class="mt-2 text-lg font-semibold tracking-tight text-slate-950">
                                        {{ $supporter['name'] }}
                                    </h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">
                                        {{ $supporter['description'] }}
                                    </p>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
                </div>
            </section>
        @endif

        <section class="py-10 lg:py-14">
            <div class="space-y-8 lg:space-y-10">
                @foreach ($supportSections as $section)
                    <div class="px-1 sm:px-2">
                        <h2 class="text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl">
                            {{ $section['title'] }}
                        </h2>
                    </div>

                    <x-infinite-marquee
                        class="-mt-4"
                        :items="$section['items']"
                        :mode="$section['mode']"
                        :direction="$section['direction']"
                        :speed="$section['speed']"
                        :gap="$section['gap']"
                        :fade-color="$section['fadeColor']"
                        :image-fit="$section['imageFit'] ?? 'contain'"
                        :full-width="true"
                        aria-label="{{ $section['title'] }}"
                    />
                @endforeach
            </div>
        </section>
    </div>

    <div class="mx-auto w-full max-w-[120rem] px-4 sm:px-6 lg:px-8">
        <section class="py-10 lg:py-14">
            <div class="space-y-10 lg:space-y-12">
                @foreach ($proposedSections as $section)
                    @if ($section['visible'])
                        @php($isSliderSection = in_array($section['title'], ['Clubes propuestos para la asamblea', 'Jugadores propuestos para la asamblea'], true))
                        @php($isClubSliderSection = $section['title'] === 'Clubes propuestos para la asamblea')

                        <div>
                            <h2 class="text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl">
                                {{ $section["title"] }}
                            </h2>

                            <div @class([
                                'mt-6',
                                'flex gap-5 overflow-x-auto pb-3 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden' => $isSliderSection,
                                'grid gap-6 lg:grid-cols-3' => ! $isSliderSection,
                            ])>
                                @foreach ($section["items"] as $person)
                                    <article @class([
                                        'overflow-hidden rounded-[1.9rem] border border-slate-200 bg-slate-50 shadow-[0_10px_30px_rgba(15,23,42,0.05)]',
                                        'min-w-[14rem] snap-start sm:min-w-[15rem] lg:min-w-[16rem]' => $isClubSliderSection,
                                        'min-w-[18rem] snap-start sm:min-w-[20rem] lg:min-w-[22rem]' => $isSliderSection && ! $isClubSliderSection,
                                    ])>
                                        <div @class([
                                            'relative bg-gradient-to-br from-brand-950 via-slate-900 to-slate-800',
                                            'aspect-[3/4]' => $isClubSliderSection,
                                            'aspect-[4/5]' => ! $isClubSliderSection,
                                        ])>
                                            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(251,191,36,0.22),transparent_40%)]"></div>
                                            <div @class([
                                                'absolute inset-0 grid place-items-center',
                                                'p-4' => $isClubSliderSection,
                                                'p-6' => ! $isClubSliderSection,
                                            ])>
                                                <div @class([
                                                    'grid place-items-center rounded-[2rem] border border-white/10 bg-white/10 font-semibold tracking-[0.24em] text-white backdrop-blur-sm',
                                                    'size-20 text-xl' => $isClubSliderSection,
                                                    'size-28 text-3xl' => ! $isClubSliderSection,
                                                ])>
                                                    {{ $person["initials"] }}
                                                </div>
                                            </div>
                                        </div>

                                        <div @class([
                                            'p-4' => $isClubSliderSection,
                                            'p-6' => ! $isClubSliderSection,
                                        ])>
                                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">
                                                Propuesto para la asamblea
                                            </p>
                                            <h3 @class([
                                                'mt-3 font-semibold tracking-tight text-slate-950',
                                                'text-base sm:text-lg' => $isClubSliderSection,
                                                'text-xl' => ! $isClubSliderSection,
                                            ])>
                                                {{ $person["name"] }}
                                            </h3>
                                            <p @class([
                                                'mt-2 font-medium text-slate-600',
                                                'text-xs sm:text-sm' => $isClubSliderSection,
                                                'text-sm' => ! $isClubSliderSection,
                                            ])>
                                                {{ $person["title"] }}
                                            </p>
                                            @if (! empty($person["description"]))
                                                <p @class([
                                                    'mt-4 leading-7 text-slate-600',
                                                    'text-xs sm:text-sm' => $isClubSliderSection,
                                                    'text-sm' => ! $isClubSliderSection,
                                                ])>
                                                    {{ $person["description"] }}
                                                </p>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    </div>
@endsection



