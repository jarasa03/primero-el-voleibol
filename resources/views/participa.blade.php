@extends('layouts.public')

@section('title', 'Participa')
@section('meta_description', 'Cuéntanos tus ideas para mejorar el voleibol madrileño y ayúdanos a construir un proyecto más útil, claro y abierto.')
@section('body_class', 'page-interior page-participa')

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

        <div class="relative mx-auto max-w-7xl px-4 pt-20 pb-5 sm:px-0 sm:pt-[5.5rem] sm:pb-12 lg:pt-24 lg:pb-14">
            <div class="flex h-full max-w-4xl flex-col justify-center">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Participa</p>
                <h1 class="mt-2 max-w-3xl text-3xl font-semibold tracking-tight text-white sm:mt-3 sm:text-5xl lg:text-5xl">
                    Cuéntanos qué cambiarías en el voleibol madrileño.
                </h1>

                <p class="mt-4 max-w-3xl text-base leading-7 text-brand-200 sm:mt-5 sm:text-xl sm:leading-8">
                    Si tienes una idea, una mejora o una experiencia que pueda ayudar a ordenar mejor el voleibol,
                    este es el sitio. Nos interesa la voz de la pista, pero también la de quienes la rodean.
                </p>
            </div>
        </div>
    </section>

    <section class="py-4 lg:py-5">
        <div class="grid gap-6 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
            <div class="space-y-6">
                <div class="rounded-[2rem] border border-slate-200 bg-slate-50 px-6 py-6 shadow-sm sm:px-8 lg:px-10 lg:py-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Qué puedes enviarnos</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Un canal abierto para ideas que suman
                    </h2>
                    <p class="mt-4 text-lg leading-8 text-slate-700">
                        No hace falta que vengas con un documento perfecto. Si ves algo mejorable, una propuesta para
                        clubes, formación, arbitraje, competición, comunicación o cualquier otra parte del proyecto,
                        queremos escucharte.
                    </p>

                    <div class="mt-6 space-y-3 text-sm leading-6 text-slate-600">
                        <p>• Problemas que se repiten y merecen una solución clara.</p>
                        <p>• Cambios sencillos que podrían mejorar la experiencia en pista.</p>
                        <p>• Propuestas de largo recorrido para el voleibol madrileño.</p>
                        <p>• Observaciones sobre arbitraje, competición, formación o clubes.</p>
                    </div>

                    <div class="mt-8 rounded-[1.5rem] border border-slate-200 bg-white px-5 py-5">
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Privacidad</p>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            Lo que nos envías es privado y solo lo utilizamos para revisar ideas y devolver contexto cuando
                            haga falta. No publicamos tus datos ni compartimos el contenido fuera del proyecto.
                        </p>
                    </div>
                </div>

                <div class="hidden gap-6 lg:grid">
                    <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-amber-400"></span>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Ideas útiles</p>
                        </div>
                        <h2 class="mt-5 text-xl font-semibold tracking-tight text-slate-950">Propuestas que se puedan trabajar</h2>
                        <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                            Nos sirven las observaciones concretas: una mejora de calendario, una forma más clara de
                            comunicar decisiones o una propuesta para mejorar cómo funciona algo en la práctica.
                        </p>
                    </article>

                    <article class="rounded-[1.75rem] border border-slate-200 bg-slate-100 p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-slate-700"></span>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Experiencia real</p>
                        </div>
                        <h2 class="mt-5 text-xl font-semibold tracking-tight text-slate-950">Lo que pasa en pista importa</h2>
                        <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                            Queremos leer lo que ves cada semana: problemas repetidos, buenas prácticas y todo aquello que
                            ayudaría a que el entorno sea más justo y mejor organizado.
                        </p>
                    </article>

                    <article class="rounded-[1.75rem] border border-slate-900 bg-slate-950 p-6 text-white shadow-[0_18px_40px_rgba(15,23,42,0.18)]">
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-amber-400"></span>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-100/80">Trabajo serio</p>
                        </div>
                        <h2 class="mt-5 text-xl font-semibold tracking-tight text-white">Tu idea no cae en saco roto</h2>
                        <p class="mt-3 text-[1rem] leading-7 text-brand-200">
                            Leemos, ordenamos y filtramos cada mensaje para convertirlo en propuestas útiles. Si algo merece
                            desarrollarse, lo incorporamos al debate.
                        </p>
                    </article>
                </div>
            </div>

            <div id="formulario" class="rounded-[2rem] border border-slate-200 bg-white px-6 py-6 shadow-sm sm:px-8 lg:px-10 lg:py-8">
                <div class="max-w-2xl">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Formulario</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Cuéntanos tu idea
                    </h2>
                    <p class="mt-4 text-base leading-7 text-slate-600">
                        Responde con la mayor claridad posible. Si tu propuesta tiene detalle, mejor: nos ayuda a
                        entenderla y a trabajarla con más precisión.
                    </p>
                </div>

                @if (session('status'))
                    <div class="mt-6 rounded-[1.5rem] border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm leading-6 text-emerald-900">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 rounded-[1.5rem] border border-rose-200 bg-rose-50 px-5 py-4 text-sm leading-6 text-rose-900">
                        <p class="font-semibold">Revisa el formulario</p>
                        <ul class="mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    class="mt-6 grid gap-5"
                    action="{{ route('participa.store') }}"
                    method="post"
                    data-participation-form
                >
                    @csrf

                    <div class="hidden">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off" value="{{ old('website') }}">
                    </div>

                    <fieldset class="grid gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4">
                        <legend class="px-1 text-sm font-semibold text-slate-900">¿Quieres reflejar la propuesta de forma privada?</legend>

                        <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3">
                            <input
                                type="radio"
                                name="response_preference"
                                value="public"
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
                    </fieldset>

                    <div class="grid gap-5 sm:grid-cols-2" data-participation-identity-field @if(old('response_preference') === 'private') hidden @endif>
                        <label class="grid gap-2">
                            <span class="text-sm font-semibold text-slate-900">Nombre</span>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                                placeholder="Tu nombre"
                                autocomplete="name"
                                data-participation-name
                            >
                            @error('name')
                                <span class="text-sm text-rose-600">{{ $message }}</span>
                            @enderror
                        </label>

                        <label class="grid gap-2">
                            <span class="text-sm font-semibold text-slate-900">Correo electrónico</span>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
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
                        <span class="text-sm font-semibold text-slate-900">Club, equipo o rol</span>
                        <input
                            type="text"
                            name="club_or_role"
                            value="{{ old('club_or_role') }}"
                            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                            placeholder="Ej.: entrenador, árbitro, club, jugador..."
                            autocomplete="organization-title"
                        >
                        @error('club_or_role')
                            <span class="text-sm text-rose-600">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="grid gap-2">
                        <span class="text-sm font-semibold text-slate-900">Sobre qué quieres aportar</span>
                        <select
                            name="topic"
                            class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
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
                        <span class="text-sm font-semibold text-slate-900">Tu idea</span>
                        <textarea
                            name="idea"
                            rows="8"
                            class="rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-3 text-sm leading-7 text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                            placeholder="Cuéntanos qué cambiarías, por qué y cómo crees que podría aplicarse."
                            required
                        >{{ old('idea') }}</textarea>
                        @error('idea')
                            <span class="text-sm text-rose-600">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="flex items-start gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4">
                        <input
                            type="checkbox"
                            name="consent"
                            value="1"
                            @checked(old('consent'))
                            class="mt-1 size-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500"
                            required
                        >
                        <span class="text-sm leading-6 text-slate-600">
                            Acepto que uséis mis datos para revisar esta propuesta y, si hace falta, responderme sobre
                            ella. No se publicará nada sin permiso.
                        </span>
                    </label>
                    @error('consent')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror

                    <div class="flex flex-wrap items-center gap-3 pt-1">
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-slate-800">
                            Enviar propuesta
                        </button>
                        <p class="text-sm leading-6 text-slate-500">
                            Respondemos con calma y tratamos cada mensaje como material de trabajo.
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="py-4 lg:py-5">
        <div class="rounded-[2rem] border border-slate-200 bg-slate-950 px-6 py-7 text-white shadow-[0_22px_60px_rgba(15,23,42,0.22)] sm:px-8 lg:px-10 lg:py-10">
            <div class="grid gap-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Último empujón</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                        Si tienes una buena idea, este es el momento de contarla.
                    </h2>
                    <p class="mt-4 max-w-2xl text-lg leading-8 text-brand-200">
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
