@extends('layouts.public')

@section('title', 'Primero el Voleibol')
@section('meta_description', 'Primero el Voleibol es un proyecto abierto para mejorar el voleibol madrileño con propuestas concretas, debate y participación.')
@section('body_class', 'page-home')

@section('content')
    <section class="pb-6 pt-6 lg:pb-7 lg:pt-7">
        <div class="relative overflow-hidden rounded-[2.25rem] bg-slate-950 px-4 py-10 text-white shadow-[0_28px_80px_rgba(15,23,42,0.24)] sm:px-6 lg:px-8 lg:py-12">
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-25 mix-blend-soft-light"
                    style="background-image: url('https://source.unsplash.com/featured/1600x900/?volleyball%2Ccourt%2Csport');"
                ></div>
                <div class="absolute inset-0 bg-[linear-gradient(118deg,rgba(15,23,42,0.97)_8%,rgba(15,23,42,0.84)_42%,rgba(15,23,42,0.58)_100%)]"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(251,191,36,0.20),transparent_42%)]"></div>
                <div class="absolute inset-x-0 bottom-0 h-px bg-white/10"></div>
            </div>

            <div class="relative grid gap-8 lg:grid-cols-[1.25fr_0.75fr] lg:items-start">
                <div class="max-w-4xl lg:pt-2">
                    <p class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-brand-100">
                        <span class="size-2 rounded-full bg-amber-400"></span>
                        Movimiento cívico y deportivo en Madrid
                    </p>

                    <h1 class="mt-6 max-w-3xl text-5xl font-semibold tracking-tight text-white sm:text-6xl lg:text-7xl">
                        Primero el voleibol.
                        <span class="block text-brand-100">Un proyecto para mejorarlo.</span>
                    </h1>

                    <p class="mt-6 max-w-3xl text-lg leading-8 text-brand-200 sm:text-xl">
                        Un proyecto abierto para escuchar a quienes viven el voleibol madrileño, poner sobre la mesa problemas concretos y trabajar soluciones que puedan mejorar la competición, la formación y la vida de clubes y colectivos.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('proyecto') }}" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300">
                            Conoce el proyecto
                        </a>
                        <a href="{{ route('programa') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-white/10">
                            Ver propuestas
                        </a>
                    </div>

                    <p class="mt-8 max-w-3xl border-l-4 border-amber-400 pl-4 text-xl font-medium leading-9 text-white">
                        Queremos que el voleibol madrileño tenga una organización a la altura de quienes lo sostienen cada semana.
                    </p>
                </div>

                <aside class="lg:justify-self-end">
                    <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-[0_12px_30px_rgba(15,23,42,0.18)]">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Cómo trabajamos</p>
                        <div class="mt-5 grid gap-3">
                            <div class="rounded-2xl border border-white/10 bg-slate-900/40 p-4">
                                <p class="text-base font-semibold text-white">Conocer la realidad</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Partir de lo que viven clubes, jugadores, entrenadores, árbitros y familias.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/30 p-4">
                                <p class="text-base font-semibold text-white">Proponer con criterio</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Convertir problemas y experiencias en medidas concretas, viables y útiles.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/20 p-4">
                                <p class="text-base font-semibold text-white">Sumar voces</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Mantener un proyecto abierto al debate y a las aportaciones de toda la comunidad.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section id="proyecto" class="py-6 lg:py-7">
        <div class="rounded-[2rem] border border-slate-200 bg-white px-4 py-8 shadow-sm sm:px-6 lg:px-8 lg:py-10">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Proyecto</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Un proyecto que empieza por escuchar</h2>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="size-3 rounded-full bg-amber-400"></span>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Realidad</p>
                </div>
                <h3 class="mt-5 text-xl font-semibold text-slate-950">El voleibol se construye desde abajo</h3>
                <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                    Clubes, jugadores, entrenadores, árbitros y familias conocen de primera mano qué funciona y qué se puede mejorar.
                </p>
            </article>

            <article id="principios" class="rounded-[1.75rem] border border-slate-200 bg-slate-100 p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="size-3 rounded-full bg-slate-700"></span>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Principios</p>
                </div>
                <h3 class="mt-5 text-xl font-semibold text-slate-950">Claridad, transparencia y trabajo</h3>
                <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                    Defendemos un debate claro y una forma de trabajar abierta, responsable y pegada a la práctica del voleibol madrileño.
                </p>
            </article>

            <article id="participa" class="rounded-[1.75rem] border border-slate-900 bg-slate-950 p-6 text-white shadow-[0_18px_40px_rgba(15,23,42,0.18)]">
                <div class="flex items-center gap-3">
                    <span class="size-3 rounded-full bg-amber-400"></span>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-100/80">Participación</p>
                </div>
                <h3 class="mt-5 text-xl font-semibold text-white">Las ideas tienen que circular</h3>
                <p class="mt-3 text-[1rem] leading-7 text-brand-200">
                    Primero el Voleibol no quiere hablar solo. Queremos recibir experiencias, ideas y propuestas de quienes forman parte de este deporte.
                </p>
            </article>
        </div>
        </div>
    </section>

    <section id="programa" class="py-6 lg:py-7">
        <div class="rounded-[2rem] border border-slate-200 bg-white px-4 py-8 shadow-sm sm:px-6 lg:px-8 lg:py-10">
            <div class="max-w-3xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Programa</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Propuestas para problemas concretos
                    </h2>
                    <p class="mt-4 max-w-2xl text-lg leading-8 text-slate-700">
                        Ya hay medidas trabajadas sobre la mesa. Estas son una muestra de los cambios que proponemos para que el voleibol madrileño funcione mejor.
                    </p>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                @forelse ($homeProposals as $proposal)
                    <article @class([
                        'rounded-[1.75rem] p-6 shadow-sm',
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
                            ])>{{ $proposal['section']->name }}</p>
                        </div>
                        <h3 @class([
                            'mt-5 text-xl font-semibold tracking-tight',
                            'text-slate-950' => $loop->iteration !== 2,
                            'text-white' => $loop->iteration === 2,
                        ])>
                            {{ $proposal['proposal']->title }}
                        </h3>
                        <p @class([
                            'mt-3 text-[1rem] leading-7',
                            'text-slate-600' => $loop->iteration !== 2,
                            'text-brand-200' => $loop->iteration === 2,
                        ])>
                            {{ $proposal['excerpt'] }}
                        </p>
                    </article>
                @empty
                    <p class="text-slate-600">Estamos preparando nuevas propuestas para publicar.</p>
                @endforelse
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('programa') }}" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition md:hover:bg-slate-800">Ver todas las propuestas</a>
            </div>

            <div class="mt-8 rounded-[1.75rem] border border-slate-200 bg-slate-100 px-4 py-6 sm:px-6 lg:px-8">
                <div class="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-accent-700">Aporta más</p>
                        <p class="mt-2 max-w-2xl text-base leading-7 text-slate-700">
                            Si ves otra medida que debería entrar en el programa, nos encantaría leerla. Queremos
                            que este espacio crezca con ideas útiles y bien pensadas.
                        </p>
                    </div>

                    <a href="{{ route('participa') }}" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition md:hover:bg-slate-800">
                        Escríbenos
                    </a>
            </div>
        </div>
    </section>

    <section id="blog" class="py-6 lg:py-7">
        <div class="p-0">
            <div class="max-w-2xl">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500">Blog</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Últimas publicaciones</h2>
            </div>

            @if ($latestPosts->isNotEmpty())
                <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($latestPosts as $post)
                        <a href="{{ route('blog.show', $post) }}" class="group overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 transition md:hover:border-slate-300 md:hover:bg-white">
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
                                        Nuevo!
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
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-700">Aquí publicaremos novedades, reflexiones y propuestas para seguir dando forma al proyecto.</p>
            @endif
            <a href="{{ route('blog') }}" class="mt-6 inline-flex font-semibold text-accent-700 transition md:hover:text-accent-900">Ver toda la actualidad</a>
        </div>
    </section>

    <section id="sumate" class="py-6 lg:py-7">
        <div class="rounded-[2.25rem] bg-slate-950 px-4 py-8 text-white shadow-[0_22px_60px_rgba(15,23,42,0.22)] sm:px-6 lg:px-8 lg:py-10">
            <div class="grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Participa</p>
                    <h2 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-3xl">
                        El proyecto también se construye con lo que tú ves cada semana.
                    </h2>
                    <p class="mt-4 max-w-2xl text-lg leading-8 text-brand-200">
                        Si formas parte del voleibol madrileño y hay algo que debería cambiar, queremos escucharlo.
                    </p>
                </div>

                <div class="lg:justify-self-end">
                    <a href="{{ route('participa') }}" class="inline-flex w-full items-center justify-center rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-white/10 sm:w-auto">
                        Participa o aporta una idea
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
