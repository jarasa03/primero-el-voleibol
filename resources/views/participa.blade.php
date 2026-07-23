@extends('layouts.public')

@section('title', 'Participa | Primero el Voleibol')
@section('meta_description', 'Cuéntanos tus ideas para mejorar el voleibol madrileño y ayúdanos a construir un proyecto más útil, claro y abierto.')
@section('body_class', 'page-interior page-participa')

@push('head')
    <link rel="canonical" href="{{ route('participa') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="Participa | Primero el Voleibol">
    <meta property="og:description" content="Cuéntanos tus ideas para mejorar el voleibol madrileño y ayúdanos a construir un proyecto más útil, claro y abierto.">
    <meta property="og:url" content="{{ route('participa') }}">
    <meta property="og:image" content="{{ asset('images/participa-hero.webp') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Participa | Primero el Voleibol">
    <meta name="twitter:description" content="Cuéntanos tus ideas para mejorar el voleibol madrileño y ayúdanos a construir un proyecto más útil, claro y abierto.">
    <meta name="twitter:image" content="{{ asset('images/participa-hero.webp') }}">
@endpush

@section('content')
    @php
        $heroImage = asset('images/participa-hero.webp');
        $topics = [
            'clubes' => 'Clubes',
            'arbitraje' => 'Arbitraje',
            'formacion' => 'Formación',
            'competicion' => 'Competición',
            'comunicacion' => 'Comunicación',
            'otro' => 'Otro',
        ];
    @endphp

    <section
        class="relative left-1/2 w-screen -translate-x-1/2 -mt-24 overflow-hidden bg-cover bg-center bg-no-repeat text-white sm:-mt-28 lg:-mt-28"
        style="background-image: url('{{ $heroImage }}');"
    >
        <div class="absolute inset-0 bg-slate-950/80"></div>

        <div class="relative mx-auto max-w-[120rem] px-4 pt-24 pb-8 sm:px-6 sm:pt-[5.5rem] sm:pb-12 lg:px-8 lg:pt-24 lg:pb-14">
            <div class="flex h-full max-w-4xl flex-col justify-center">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300 sm:text-sm sm:tracking-[0.25em]">Participa</p>
                <h1 class="mt-2 max-w-3xl text-2xl font-semibold tracking-tight text-white sm:mt-3 sm:text-5xl lg:text-5xl">
                    Cuéntanos qué cambiarías en el voleibol madrileño.
                </h1>

                <p class="mt-4 max-w-3xl text-sm leading-6 text-brand-200 sm:mt-5 sm:text-xl sm:leading-8">
                    Si tienes una idea, una mejora o una experiencia que pueda ayudar a ordenar mejor el voleibol,
                    este es el sitio. Nos interesa la voz de la pista, pero también la de quienes la rodean.
                </p>
            </div>
        </div>
    </section>

    <section class="py-4 sm:py-5" aria-labelledby="participa-contenido-heading">
        <h2 id="participa-contenido-heading" class="sr-only">Qué puedes enviarnos</h2>

        <div class="grid gap-5 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
            <div class="space-y-5 sm:space-y-6">
                <div class="rounded-[2rem] border border-slate-200 bg-slate-50 px-4 py-5 shadow-sm sm:px-6 lg:px-8 lg:py-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-accent-700 sm:text-sm sm:tracking-[0.25em]">Qué puedes enviarnos</p>
                    <h3 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Un canal abierto para ideas que suman
                    </h3>
                    <p class="mt-3 text-base leading-7 text-slate-700 sm:mt-4 sm:text-lg sm:leading-8">
                        Si ves algo mejorable, queremos escucharte. Nos interesan tanto las mejoras concretas como las
                        propuestas de fondo para el voleibol madrileño.
                    </p>

                    <div class="mt-5 space-y-2.5 text-sm leading-6 text-slate-600 sm:mt-6 sm:space-y-3">
                        <p>• Problemas que se repiten y merecen una solución clara.</p>
                        <p>• Cambios sencillos que podrían mejorar la experiencia en pista.</p>
                        <p>• Observaciones sobre arbitraje, competición, formación o clubes.</p>
                    </div>

                    <div class="mt-6 rounded-[1.5rem] border border-slate-200 bg-white px-4 py-4 sm:px-6 sm:py-5 lg:px-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.24em] text-slate-500 sm:text-sm">Privacidad</p>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            Lo que nos envías es privado y solo lo utilizamos para revisar ideas y devolver contexto cuando haga falta.
                        </p>
                    </div>
                </div>

                <div class="hidden gap-5 lg:grid">
                    <article class="rounded-[1.75rem] border border-slate-200 bg-white px-4 py-6 shadow-sm sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-amber-400"></span>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Ideas útiles</p>
                        </div>
                        <h3 class="mt-5 text-xl font-semibold tracking-tight text-slate-950">Propuestas que se puedan trabajar</h3>
                        <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                            Nos sirven las observaciones concretas y las propuestas útiles para la práctica.
                        </p>
                    </article>

                    <article class="rounded-[1.75rem] border border-slate-200 bg-slate-100 px-4 py-6 shadow-sm sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-slate-700"></span>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Experiencia real</p>
                        </div>
                        <h3 class="mt-5 text-xl font-semibold tracking-tight text-slate-950">Lo que pasa en pista importa</h3>
                        <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                            Lo que ves cada semana ayuda a detectar lo que realmente necesita mejora.
                        </p>
                    </article>

                    <article class="rounded-[1.75rem] border border-slate-900 bg-slate-950 px-4 py-6 text-white shadow-[0_18px_40px_rgba(15,23,42,0.18)] sm:px-6 lg:px-8">
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-amber-400"></span>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-100/80">Trabajo serio</p>
                        </div>
                        <h3 class="mt-5 text-xl font-semibold tracking-tight text-white">Tu idea no cae en saco roto</h3>
                        <p class="mt-3 text-[1rem] leading-7 text-brand-200">
                            Leemos, ordenamos y filtramos cada mensaje para darles seguimiento.
                        </p>
                    </article>
                </div>
            </div>

            <section id="formulario" class="rounded-[2rem] border border-slate-200 bg-white px-4 py-5 shadow-sm sm:px-6 lg:px-8 lg:py-8" aria-labelledby="participa-formulario-heading">
                <h2 id="participa-formulario-heading" class="sr-only">Cuéntanos tu idea</h2>

                <div class="max-w-2xl">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-accent-700 sm:text-sm sm:tracking-[0.25em]">Formulario</p>
                    <h3 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Cuéntanos tu idea
                    </h3>
                    <p class="mt-3 text-sm leading-6 text-slate-600 sm:mt-4 sm:text-base sm:leading-7">
                        Responde con la mayor claridad posible. Si tu propuesta tiene detalle, mejor: nos ayuda a
                        entenderla y a trabajarla con más precisión.
                    </p>
                </div>

                @if (session('status'))
                    <div class="mt-5 rounded-[1.5rem] border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm leading-6 text-emerald-900 sm:mt-6 sm:px-5">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-5 rounded-[1.5rem] border border-rose-200 bg-rose-50 px-4 py-4 text-sm leading-6 text-rose-900 sm:mt-6 sm:px-5">
                        <p class="font-semibold">Revisa el formulario</p>
                        <ul class="mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    class="mt-5 grid gap-4 sm:mt-6 sm:gap-5"
                    action="{{ route('participa.store') }}"
                    method="post"
                    data-participation-form
                >
                    @csrf

                    <div class="hidden">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off" value="{{ old('website') }}">
                    </div>

                    <div class="grid gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4 sm:px-6 sm:py-5 lg:px-8">
                        <p class="text-sm font-semibold leading-6 text-slate-900 sm:text-base">
                            ¿Quieres reflejar la propuesta de forma privada?
                            <span class="align-top text-rose-500">*</span>
                        </p>

                        <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3">
                            <input
                                type="radio"
                                name="response_preference"
                                value="public"
                                required
                                @checked(old('response_preference', 'public') === 'public')
                                data-response-preference
                                class="mt-1 size-4 border-slate-300 text-amber-500 focus:ring-amber-500"
                            >
                            <span class="text-sm leading-6 text-slate-700">
                                No, quiero que aparezca con mi nombre y correo.
                            </span>
                        </label>

                        <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3">
                            <input
                                type="radio"
                                name="response_preference"
                                value="private"
                                @checked(old('response_preference') === 'private')
                                data-response-preference
                                class="mt-1 size-4 border-slate-300 text-amber-500 focus:ring-amber-500"
                            >
                            <span class="text-sm leading-6 text-slate-700">
                                Sí, quiero enviarla de forma privada. La idea llegará igual, pero no aparecerán mis datos.
                            </span>
                        </label>

                        @error('response_preference')
                            <span class="text-sm text-rose-600">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2 sm:gap-5" data-participation-identity-field @if(old('response_preference') === 'private') hidden @endif>
                        <label class="grid gap-2">
                            <span class="text-sm font-semibold text-slate-900">
                                Nombre <span class="align-top text-rose-500">*</span>
                            </span>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                                placeholder="Tu nombre"
                                autocomplete="name"
                                data-participation-name
                            >
                            @error('name')
                                <span class="text-sm text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="grid gap-2">
                            <span class="text-sm font-semibold text-slate-900">
                                Correo electrónico <span class="align-top text-rose-500">*</span>
                            </span>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                                placeholder="Solo si quieres respuesta"
                                autocomplete="email"
                                data-participation-email
                            >
                            @error('email')
                                <span class="text-sm text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>
                    </div>

                    <label class="grid gap-2">
                        <span class="text-sm font-semibold text-slate-900">
                            Club, equipo o rol <span class="align-top text-rose-500">*</span>
                        </span>
                        <input
                            type="text"
                            name="club_or_role"
                            value="{{ old('club_or_role') }}"
                            required
                            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                            placeholder="Ej.: entrenador, árbitro, club, jugador..."
                            autocomplete="organization-title"
                        >
                        @error('club_or_role')
                            <span class="text-sm text-rose-600">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-sm font-semibold text-slate-900">
                            Sobre qué quieres aportar <span class="align-top text-rose-500">*</span>
                        </span>
                        <select
                            name="topic"
                            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                            required
                        >
                            <option value="">Selecciona una opción</option>
                            @foreach ($topics as $value => $label)
                                <option value="{{ $value }}" @selected(old('topic') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('topic')
                            <span class="text-sm text-rose-600">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-sm font-semibold text-slate-900">
                            Tu idea <span class="align-top text-rose-500">*</span>
                        </span>
                        <textarea
                            name="idea"
                            rows="6"
                            class="h-36 sm:h-44 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-3 text-base leading-7 text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                            placeholder="Cuéntanos qué cambiarías, por qué y cómo crees que podría aplicarse."
                            required
                        >{{ old('idea') }}</textarea>
                        @error('idea')
                            <span class="text-sm text-rose-600">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="flex items-start gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4 sm:px-6 lg:px-8">
                        <input
                            type="checkbox"
                            name="consent"
                            value="1"
                            @checked(old('consent'))
                            class="mt-1 size-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500"
                            required
                        >
                        <span class="text-sm leading-6 text-slate-600">
                            <span class="align-top text-rose-500">*</span>
                            Acepto que uséis mis datos para revisar esta propuesta y, si hace falta, responderme sobre
                            ella. No se publicará nada sin permiso.
                        </span>
                    </label>
                    @error('consent')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror

                    <div class="flex flex-col gap-3 pt-1 sm:flex-row sm:items-center">
                        <button type="submit" class="inline-flex w-full cursor-pointer items-center justify-center whitespace-nowrap rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white shadow-sm transition duration-200 md:hover:-translate-y-0.5 md:hover:bg-slate-800 md:hover:shadow-lg sm:w-auto">
                            Enviar idea
                        </button>
                        <p class="text-sm leading-6 text-slate-500">
                            Respondemos con calma y tratamos cada mensaje como material de trabajo.
                        </p>
                    </div>
                </form>
            </section>
        </div>
    </section>

    <section class="py-4 sm:py-5">
        <div class="rounded-[2rem] border border-slate-200 bg-slate-950 px-4 py-6 text-white shadow-[0_22px_60px_rgba(15,23,42,0.22)] sm:px-6 lg:px-8 lg:py-10">
            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300 sm:text-sm sm:tracking-[0.25em]">Último empujón</p>
                    <h2 class="mt-3 text-2xl font-semibold tracking-tight text-white sm:text-4xl">
                        Si tienes una buena idea, este es el momento de contarla.
                    </h2>
                    <p class="mt-3 max-w-2xl text-base leading-7 text-brand-200 sm:mt-4 sm:text-lg sm:leading-8">
                        Queremos un proyecto útil, abierto y bien pensado. Cuanto más concreta sea tu aportación,
                        más fácil será transformarla en algo que de verdad ayude.
                    </p>
                </div>

                <div class="lg:justify-self-end">
                    <a href="#formulario" class="inline-flex w-full items-center justify-center rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-white/10 sm:w-auto">
                        Volver al formulario
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
