@extends('layouts.public')

@section('title', 'Primero el Voleibol | Proyecto para mejorar el voleibol madrileño')
@section('meta_description', 'Primero el Voleibol es un proyecto abierto para mejorar el voleibol madrileño con propuestas concretas, debate y participación.')
@section('og_image', asset('images/hero-home.jpg'))
@section('body_class', 'page-home')
@section('main_wrapper_class', 'pt-20 sm:pt-28 lg:pt-28')

@section('content')
    @php
        $primaryCtaInteractionClasses = 'transition-colors duration-200 ease-out hover:bg-amber-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white';
        $darkCtaInteractionClasses = 'ring-1 ring-slate-950 transition-[background-color,box-shadow] duration-200 ease-out hover:bg-slate-800 hover:ring-slate-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-400';
        $invertedCtaInteractionClasses = 'transition-[background-color,border-color] duration-200 ease-out hover:border-white/35 hover:bg-white/10 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-amber-300';
        $editorialCtaInteractionClasses = 'group transition-colors duration-200 ease-out hover:text-accent-900 focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-accent-700';
    @endphp

    <section class="pb-5 pt-4 sm:pb-6 sm:pt-6 lg:pb-7 lg:pt-7">
        <div data-home-hero class="overflow-hidden rounded-[1.75rem] bg-slate-950 text-white sm:rounded-[2rem]">
            <div class="grid lg:min-h-[600px] lg:grid-cols-[0.9fr_1.1fr]">
                <div class="flex flex-col justify-center px-5 py-5 sm:px-8 sm:py-14 lg:px-10 lg:py-12 xl:px-14">
                    <div class="max-w-3xl">
                        <p data-home-hero-kicker class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-3 py-1.5 text-xs font-medium text-brand-100 sm:px-4 sm:py-2 sm:text-sm">
                            <span class="size-2 rounded-full bg-amber-400"></span>
                            Movimiento cívico y deportivo en Madrid
                        </p>

                        <h1 class="mt-5 text-[2.625rem] font-semibold leading-[1.04] tracking-tight text-white sm:mt-6 sm:text-6xl lg:text-[3.75rem] xl:text-7xl">
                            <span class="block overflow-hidden"><span data-home-hero-title-line class="block">Primero el Voleibol.</span></span>
                            <span class="mt-1.5 block overflow-hidden sm:mt-2"><span data-home-hero-title-line class="block text-[2rem] font-medium leading-[1.08] text-brand-100 sm:text-5xl lg:text-5xl xl:text-6xl">Un proyecto para mejorar el voleibol madrileño.</span></span>
                        </h1>

                        <p data-home-hero-description class="mt-4 max-w-xl text-[0.9375rem] leading-6 text-brand-200 sm:mt-6 sm:text-lg sm:leading-8">
                            Una iniciativa para escuchar a quienes viven el voleibol madrileño, poner sobre la mesa problemas concretos y trabajar soluciones que puedan mejorar la competición, la formación y la vida de clubes y colectivos.
                        </p>

                        <div data-home-hero-ctas class="mt-5 flex flex-col gap-3 sm:mt-8 sm:flex-row sm:flex-wrap sm:gap-4">
                            <a href="{{ route('proyecto') }}" class="inline-flex min-h-11 w-full items-center justify-center rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 sm:w-auto {{ $primaryCtaInteractionClasses }}">
                                Conoce el proyecto
                            </a>
                            <a href="{{ route('programa') }}" class="inline-flex min-h-11 w-full items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white sm:w-auto {{ $invertedCtaInteractionClasses }}">
                                Ver propuestas
                            </a>
                        </div>

                        <p data-home-hero-statement class="mt-5 max-w-xl border-l-2 border-amber-400 pl-3 text-base font-medium leading-7 text-brand-100 sm:mt-8 sm:pl-4 sm:text-xl sm:leading-9">
                            Queremos que quienes sostienen el voleibol madrileño también tengan voz en cómo se organiza.
                        </p>
                    </div>
                </div>

                <div data-home-hero-image-frame class="relative min-h-[280px] w-full overflow-hidden sm:min-h-[380px] lg:h-full lg:min-h-0">
                    <div data-home-hero-image-wrap class="size-full lg:absolute lg:inset-x-0 lg:-inset-y-6 lg:h-auto lg:w-auto">
                        <img
                            data-home-hero-image
                            src="{{ asset('images/hero-home.jpg') }}"
                            alt="Jugadoras de voleibol celebrando junto a la red"
                            class="size-full object-cover object-[52%_center]"
                        >
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="proyecto" data-home-project class="py-5 sm:py-6 lg:py-7">
        <div class="rounded-[2rem] border border-slate-200 bg-white px-4 py-6 shadow-sm sm:px-6 sm:py-8 lg:px-8 lg:py-10">
        <div class="mb-5 flex items-end justify-between gap-4 sm:mb-6">
            <div>
                <p data-home-project-kicker class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Proyecto</p>
                <h2 data-home-project-title class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Un propósito que empieza por escuchar</h2>
            </div>
        </div>

        <div class="grid gap-4 sm:gap-6 lg:grid-cols-3">
            <article data-home-project-card class="rounded-[1.75rem] border border-slate-200 bg-white p-5 shadow-sm sm:p-6">
                <div class="flex items-center gap-3">
                    <span class="size-3 rounded-full bg-amber-400"></span>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Realidad</p>
                </div>
                <h3 class="mt-5 text-xl font-semibold text-slate-950">Partimos de quienes viven el voleibol cada semana</h3>
                <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                    Clubes, jugadores, entrenadores, árbitros y familias conocen de primera mano qué funciona y qué necesita mejorar.
                </p>
            </article>

            <article id="principios" data-home-project-card class="rounded-[1.75rem] border border-slate-200 bg-slate-100 p-5 shadow-sm sm:p-6">
                <div class="flex items-center gap-3">
                    <span class="size-3 rounded-full bg-slate-700"></span>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Principios</p>
                </div>
                <h3 class="mt-5 text-xl font-semibold text-slate-950">Propuestas claras, abiertas y aplicables</h3>
                <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                    Queremos trabajar con transparencia, responsabilidad y soluciones conectadas con la realidad del voleibol madrileño.
                </p>
            </article>

            <article id="participa" data-home-project-card class="rounded-[1.75rem] border border-slate-900 bg-slate-950 p-5 text-white shadow-[0_18px_40px_rgba(15,23,42,0.18)] sm:p-6">
                <div class="flex items-center gap-3">
                    <span class="size-3 rounded-full bg-amber-400"></span>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-100/80">Participación</p>
                </div>
                <h3 class="mt-5 text-xl font-semibold text-white">Este proyecto también se construye con tus ideas</h3>
                <p class="mt-3 text-[1rem] leading-7 text-brand-200">
                    Queremos recibir experiencias, problemas y propuestas de quienes forman parte del voleibol madrileño.
                </p>
            </article>
        </div>
        </div>
    </section>

    <section id="programa" data-home-program class="py-5 sm:py-6 lg:py-7">
        <div class="rounded-[2rem] border border-slate-200 bg-white px-4 py-6 shadow-sm sm:px-6 sm:py-8 lg:px-8 lg:py-10">
            <div class="grid gap-4 sm:gap-6 lg:grid-cols-[minmax(0,1fr)_auto] lg:items-start">
                <div class="max-w-3xl">
                    <p data-home-program-kicker class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Programa</p>
                    <h2 data-home-program-title class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Propuestas para problemas concretos
                    </h2>
                    <p data-home-program-description class="mt-3 max-w-2xl text-base leading-7 text-slate-700 sm:mt-4 sm:text-lg sm:leading-8">
                        Ya estamos trabajando en medidas concretas para mejorar distintos ámbitos del voleibol madrileño. Aquí puedes consultar las propuestas que vamos publicando.
                    </p>
                </div>

                <div class="lg:pt-1">
                    <a data-home-program-all-link href="{{ route('programa') }}" class="inline-flex min-h-11 w-full items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white sm:w-auto {{ $darkCtaInteractionClasses }}">Ver todas las propuestas</a>
                </div>
            </div>

            <div class="mt-6 grid gap-4 sm:mt-8 sm:gap-6 lg:grid-cols-3">
                @foreach ($homeProposals as $proposal)
                    <article data-home-program-card @class([
                        'rounded-[1.75rem] p-5 shadow-sm sm:p-6',
                        'border border-slate-200 bg-slate-50' => $loop->first,
                        'border border-slate-200 bg-white' => $loop->last && ! $loop->first,
                        'border border-slate-900 bg-slate-950 text-white shadow-[0_18px_40px_rgba(15,23,42,0.18)]' => $loop->iteration === 2,
                    ])>
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-amber-400"></span>
                            <p @class([
                                'text-sm font-semibold uppercase tracking-[0.22em]',
                                'text-slate-500' => $loop->iteration !== 2,
                                'text-brand-100/80' => $loop->iteration === 2,
                            ])>{{ $proposal['category'] }}</p>
                        </div>
                        <h3 @class([
                            'mt-5 text-xl font-semibold tracking-tight',
                            'text-slate-950' => $loop->iteration !== 2,
                            'text-white' => $loop->iteration === 2,
                        ])>
                            {{ $proposal['title'] }}
                        </h3>
                        <p @class([
                            'mt-3 text-[1rem] leading-7',
                            'text-slate-600' => $loop->iteration !== 2,
                            'text-brand-200' => $loop->iteration === 2,
                        ])>
                            {{ $proposal['description'] }}
                        </p>
                    </article>
                @endforeach
            </div>

            <div data-home-program-more class="mt-6 rounded-[1.75rem] border border-slate-200 bg-slate-100 px-4 py-5 sm:mt-8 sm:px-6 sm:py-6 lg:px-8">
                <div class="grid gap-4 lg:grid-cols-[minmax(0,3fr)_minmax(0,1fr)] lg:items-center">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-accent-700">Aporta más</p>
                        <p class="mt-2 text-base leading-7 text-slate-700">
                            ¿Hay algún problema que todavía no estemos abordando? Cuéntanoslo. Queremos seguir ampliando el programa con propuestas útiles, realistas y bien planteadas.
                        </p>
                    </div>

                    <div class="flex items-center justify-stretch sm:justify-end">
                        <a href="{{ route('participa') }}" class="inline-flex min-h-11 w-full items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white sm:w-auto {{ $darkCtaInteractionClasses }}">
                            Aporta una idea
                        </a>
                    </div>
            </div>
        </div>
    </section>

    <section id="blog" data-home-blog class="py-5 sm:py-6 lg:py-7">
        <div class="p-0">
            <div class="max-w-2xl">
                <p data-home-blog-kicker class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500">Blog</p>
                <h2 data-home-blog-title class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Últimas publicaciones</h2>
            </div>

            @if ($latestPosts->isNotEmpty())
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($latestPosts as $post)
                        <a data-home-blog-post href="{{ route('blog.show', $post) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition-[background-color,border-color] duration-150 ease-out md:hover:border-slate-300 md:hover:bg-white">
                            <div class="relative aspect-[16/9] overflow-hidden bg-slate-200">
                                @if (filled($post->featured_image_path))
                                    <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->title }}" class="size-full object-cover transition duration-700 group-hover:scale-105">
                                @else
                                    <div class="flex size-full items-center justify-center px-4 text-center text-sm font-medium text-slate-500">
                                        Sin imagen destacada
                                    </div>
                                @endif

                                @if ($post->isNew())
                                    <span class="absolute left-3 top-3 rounded-full bg-amber-400 px-2.5 py-1 text-[0.7rem] font-semibold uppercase tracking-[0.2em] text-slate-950">
                                        ¡Nuevo!
                                    </span>
                                @endif
                            </div>

                            <div class="p-3 sm:p-4">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">{{ $post->published_at?->format('d/m/Y') }}</p>
                                <h3 class="mt-2 font-semibold text-slate-950">{{ $post->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <p data-home-blog-introduction class="mt-5 max-w-2xl text-base leading-7 text-slate-700 sm:mt-6 sm:text-lg sm:leading-8">Aquí publicaremos novedades, reflexiones y propuestas para seguir dando forma al proyecto.</p>
            @endif
            <a data-home-blog-link href="{{ route('blog') }}" class="mt-5 inline-flex items-center gap-1.5 font-semibold text-accent-700 sm:mt-6 {{ $editorialCtaInteractionClasses }}">
                <span>Ver toda la actualidad</span>
                <span aria-hidden="true" class="transition-colors duration-200 ease-out group-hover:text-accent-900">→</span>
            </a>
        </div>
    </section>

    <section id="sumate" class="py-5 sm:py-6 lg:py-7">
        <div data-home-participa class="rounded-[2.25rem] bg-slate-950 px-4 py-6 text-white shadow-[0_22px_60px_rgba(15,23,42,0.22)] sm:px-6 sm:py-8 lg:px-8 lg:py-10">
            <div class="grid gap-5 sm:gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div class="max-w-2xl">
                    <p data-home-participa-kicker class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Participa</p>
                    <h2 data-home-participa-title class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                        Si algo del voleibol madrileño puede mejorar, queremos saberlo.
                    </h2>
                    <p data-home-participa-description class="mt-3 max-w-2xl text-base leading-7 text-brand-200 sm:mt-4 sm:text-lg sm:leading-8">
                        Cuéntanos qué funciona, qué no y qué cambiarías. Tus experiencias e ideas nos ayudan a seguir construyendo propuestas.
                    </p>
                </div>

                <div class="lg:justify-self-end">
                    <a data-home-participa-cta href="{{ route('participa') }}" class="inline-flex w-full items-center justify-center rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-semibold text-white {{ $invertedCtaInteractionClasses }} sm:w-auto">
                        Aporta una idea
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
