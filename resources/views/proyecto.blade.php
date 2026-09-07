@extends('layouts.public')

@section('title', 'Proyecto')
@section('meta_description', 'Conoce quién lidera Primero el Voleibol, los clubes y árbitros que apoyan la iniciativa, y la propuesta arbitral para la Asamblea de Madrid.')
@section('body_class', 'page-interior page-proyecto')

@section('content')
    @php($heroImage = asset('images/proyecto-hero.webp'))
    @php($collaboratorTypeByTitle = [
        'Clubes colaboradores' => 'club',
        'Árbitros colaboradores' => 'referee',
        'Entrenadores colaboradores' => 'coach',
        'Jugadores colaboradores' => 'player',
    ])

    <section
        class="relative left-1/2 w-screen -translate-x-1/2 -mt-24 overflow-hidden bg-cover bg-center bg-no-repeat text-white sm:-mt-28 lg:-mt-28"
        style="background-image: url('{{ $heroImage }}');"
    >
        <div class="absolute inset-0 bg-slate-950/60"></div>

        <div class="relative z-10 mx-auto w-full max-w-[120rem] px-4 pt-[4.5rem] pb-16 sm:px-6 sm:py-20 lg:px-8 lg:py-24">
            <div class="grid gap-10 lg:grid-cols-[1.25fr_0.75fr] lg:items-center lg:gap-12">
                <div class="flex w-full flex-col justify-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300 sm:text-sm sm:tracking-[0.25em]">Proyecto</p>
                    <h1 class="mt-2 w-full max-w-none text-4xl font-semibold tracking-tight text-white sm:mt-3 sm:text-5xl lg:text-5xl">
                        Un proyecto que se ve, se entiende y se reconoce
                    </h1>

                    <p class="mt-5 w-full max-w-none text-lg leading-8 text-brand-200 sm:text-xl">
                        Una presentación pensada para explicar el proyecto con claridad: una persona al frente,
                        apoyos reales de clubes, árbitros, entrenadores y jugadores, y una propuesta pensada para
                        dar un paso adelante en la Asamblea de Madrid.
                    </p>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('participa') }}" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300">
                            Quiero sumar apoyo
                        </a>
                    </div>
                </div>

                <aside class="lg:justify-self-end">
                    <div class="rounded-[2rem] border border-white/10 bg-white/5 p-5 shadow-[0_12px_30px_rgba(15,23,42,0.18)] backdrop-blur-sm lg:p-6">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Apoyos del proyecto</p>
                        <div class="mt-5 space-y-4">
                            <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-1">
                                <div class="rounded-2xl border border-white/10 bg-slate-900/40 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-300">Clubes</p>
                                    <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                        Respaldan el proyecto desde la experiencia de la pista y la gestión.
                                    </p>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-slate-900/30 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-300">Árbitros</p>
                                    <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                        Aportan criterio, recorrido y una mirada técnica indispensable.
                                    </p>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-slate-900/25 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-300">Entrenadores</p>
                                    <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                        Suman conocimiento del juego y de lo que necesita crecer.
                                    </p>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-slate-900/20 p-4">
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-amber-300">Jugadores</p>
                                    <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                        Representan a quienes viven el voleibol cada semana y le dan sentido.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
                </div>
        </div>
    </section>

    @if (session('status'))
        <div class="mx-auto w-full max-w-[120rem] pt-6">
            <div class="rounded-[1.5rem] border border-emerald-200 bg-emerald-50 px-4 py-4 text-sm leading-6 text-emerald-900 shadow-sm sm:px-6">
                {{ session('status') }}
            </div>
        </div>
    @endif

    <div class="mx-auto w-full max-w-[120rem]">
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
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                        <div class="max-w-4xl">
                            <p class="text-xs font-semibold uppercase tracking-[0.28em] text-accent-700 sm:text-sm sm:tracking-[0.25em]">
                                {{ $section['eyebrow'] }}
                            </p>
                            <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl">
                                {{ $section['title'] }}
                            </h2>
                            <p class="mt-2 max-w-3xl text-sm leading-7 text-slate-600 sm:text-base">
                                {{ $section['description'] }}
                            </p>
                        </div>

                        <button
                            type="button"
                            class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white shadow-sm transition md:hover:bg-slate-800 md:hover:cursor-pointer"
                            data-collaborator-modal-open
                            data-collaborator-type="{{ $collaboratorTypeByTitle[$section['title']] ?? 'club' }}"
                            data-collaborator-section="{{ $section['title'] }}"
                        >
                            Quiero salir aquí
                        </button>
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

    <div class="mx-auto w-full max-w-[120rem]">
        <section class="py-10 lg:py-14">
            <div class="space-y-10 lg:space-y-12">
                @foreach ($proposedSections as $section)
                    @if ($section['visible'])
                        @php($isSliderSection = in_array($section['title'], ['Clubes propuestos para la asamblea', 'Jugadores propuestos para la asamblea'], true))
                        @php($isClubSliderSection = $section['title'] === 'Clubes propuestos para la asamblea')
                        @php($isCoachGridSection = $section['title'] === 'Entrenadores propuestos para la asamblea')
                        @php($isCoachProposedSection = $section['title'] === 'Entrenadores propuestos para la asamblea')

                        <div>
                            <h2 class="text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl">
                                {{ $section["title"] }}
                            </h2>

                            <div class="mt-6 overflow-visible">
                                <div @class([
                                    'flex gap-5 overflow-x-auto pb-8 pt-4 lg:pb-10 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden' => $isSliderSection,
                                    'grid gap-6 lg:grid-cols-4' => $isCoachGridSection,
                                    'grid gap-6 lg:grid-cols-3' => ! $isSliderSection && ! $isCoachGridSection,
                                ])>
                                    @foreach ($section["items"] as $person)
                                        <article @class([
                                            'overflow-hidden rounded-[1.9rem] border border-slate-200 bg-slate-50 shadow-[0_10px_30px_rgba(15,23,42,0.05)]',
                                            'min-w-[18rem] snap-start sm:min-w-[20rem] lg:min-w-[22rem]' => $isSliderSection,
                                        ])>
                                            <div class="relative aspect-[4/5] bg-gradient-to-br from-brand-950 via-slate-900 to-slate-800">
                                                @php($shield = $person['shield'] ?? null)
                                                @if (! empty($person['image']))
                                                    <img
                                                        src="{{ $person['image'] }}"
                                                        alt=""
                                                        class="absolute inset-0 h-full w-full object-cover"
                                                        loading="lazy"
                                                        aria-hidden="true"
                                                    >
                                                @else
                                                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(251,191,36,0.22),transparent_40%)]"></div>
                                                @endif
                                                @if (empty($person['image']))
                                                    <div @class([
                                                        'absolute inset-0 grid place-items-center',
                                                        'p-6',
                                                    ])>
                                                        <div @class([
                                                            'grid place-items-center rounded-[2rem] border border-white/10 bg-white/10 font-semibold tracking-[0.24em] text-white backdrop-blur-sm',
                                                            'size-28 text-3xl',
                                                        ])>
                                                            {{ $person["initials"] }}
                                                        </div>
                                                    </div>
                                                @endif
                                                @if (! empty($shield))
                                                    <div @class([
                                                        'absolute z-10',
                                                        'bottom-4 right-4 size-12' => ! $isCoachProposedSection,
                                                        'bottom-5 right-5 size-14' => $isCoachProposedSection,
                                                    ])>
                                                        <img
                                                            src="{{ $shield }}"
                                                            alt=""
                                                            class="h-full w-full object-contain drop-shadow-[0_6px_12px_rgba(15,23,42,0.28)]"
                                                            aria-hidden="true"
                                                            loading="lazy"
                                                        >
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="p-6">
                                                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-slate-500">
                                                    Propuesto para la asamblea
                                                </p>
                                                <h3 class="mt-3 text-xl font-semibold tracking-tight text-slate-950">
                                                    {{ $person["name"] }}
                                                </h3>
                                                <p class="mt-2 text-sm font-medium text-slate-600">
                                                    {{ $person["title"] }}
                                                </p>
                                                @if (! empty($person["description"]))
                                                    <p class="mt-4 text-sm leading-7 text-slate-600">
                                                        {{ $person["description"] }}
                                                    </p>
                                                @endif
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </section>
    </div>

    <div
        class="fixed inset-0 z-[60] hidden items-center justify-center px-4 py-6 sm:px-6"
        data-collaborator-modal
        data-collaborator-modal-default-type="{{ old('collaborator_type', 'club') }}"
        data-collaborator-modal-open-on-load="{{ $errors->any() ? 'true' : 'false' }}"
        role="dialog"
        aria-modal="true"
        aria-labelledby="collaborator-modal-title"
        aria-hidden="true"
    >
        <button
            type="button"
            class="absolute inset-0 bg-slate-950/80"
            aria-label="Cerrar formulario"
            data-collaborator-modal-close
        ></button>

        <div class="relative flex w-full max-w-2xl max-h-[calc(100dvh-3rem)] flex-col overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-2xl shadow-slate-950/30">
            <div class="flex shrink-0 items-start justify-between gap-4 border-b border-slate-200 px-5 py-5 sm:px-6">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-accent-700 sm:text-sm sm:tracking-[0.25em]">
                        Colaboradores
                    </p>
                    <h2 id="collaborator-modal-title" class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 sm:text-3xl">
                        Quiero salir aquí
                    </h2>
                    <p class="mt-2 text-sm leading-6 text-slate-600 sm:text-base" data-collaborator-modal-section-label>
                        Cuéntanos en qué bloque encajas y mándanos tu foto y tu nombre completo.
                    </p>
                </div>

                <button
                    type="button"
                    class="inline-flex size-10 shrink-0 items-center justify-center rounded-full border border-slate-200 bg-white text-slate-600 transition hover:cursor-pointer md:hover:bg-slate-50 md:hover:text-slate-950"
                    aria-label="Cerrar formulario"
                    data-collaborator-modal-close
                >
                    <span aria-hidden="true" class="text-lg leading-none">×</span>
                </button>
            </div>

            <form
                action="{{ route('proyecto.colaboradores.store') }}"
                method="post"
                enctype="multipart/form-data"
                class="grid flex-1 gap-5 overflow-y-auto px-5 py-5 overscroll-contain sm:px-6 sm:py-6"
            >
                @csrf

                <div class="grid gap-2">
                    <label for="collaborator-type" class="text-sm font-semibold text-slate-900">
                        Dónde quieres salir <span class="align-top text-rose-500">*</span>
                    </label>
                    <select
                        id="collaborator-type"
                        name="collaborator_type"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        data-collaborator-type-input
                    >
                        <option value="club" @selected(old('collaborator_type', 'club') === 'club')>Clubes colaboradores</option>
                        <option value="referee" @selected(old('collaborator_type', 'club') === 'referee')>Árbitros colaboradores</option>
                        <option value="coach" @selected(old('collaborator_type', 'club') === 'coach')>Entrenadores colaboradores</option>
                        <option value="player" @selected(old('collaborator_type', 'club') === 'player')>Jugadores colaboradores</option>
                    </select>
                </div>

                <div class="hidden">
                    <label for="collaborator-website">Website</label>
                    <input id="collaborator-website" name="website" type="text" tabindex="-1" autocomplete="off" value="{{ old('website') }}">
                </div>

                <div class="grid gap-2">
                    <label for="collaborator-full-name" class="text-sm font-semibold text-slate-900" data-collaborator-name-label>
                        Nombre del club <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-full-name"
                        type="text"
                        name="full_name"
                        value="{{ old('full_name') }}"
                        required
                        autocomplete="name"
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="Nombre oficial del club"
                        data-collaborator-modal-name
                    >
                    @error('full_name')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2" data-collaborator-club-only>
                    <label for="collaborator-locality" class="text-sm font-semibold text-slate-900">
                        Localidad del club <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-locality"
                        type="text"
                        name="club_locality"
                        value="{{ old('club_locality') }}"
                        autocomplete="address-level2"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="Localidad del club"
                        data-collaborator-club-required
                    >
                    @error('club_locality')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2" data-collaborator-club-only>
                    <label for="collaborator-contact-name" class="text-sm font-semibold text-slate-900">
                        Nombre de la persona de contacto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-contact-name"
                        type="text"
                        name="club_contact_name"
                        value="{{ old('club_contact_name') }}"
                        autocomplete="name"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="Persona con la que contactaremos"
                        data-collaborator-club-required
                    >
                    @error('club_contact_name')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2" data-collaborator-club-only>
                    <label for="collaborator-contact-email" class="text-sm font-semibold text-slate-900">
                        Email de contacto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-contact-email"
                        type="email"
                        name="club_contact_email"
                        value="{{ old('club_contact_email') }}"
                        autocomplete="email"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="correo@ejemplo.com"
                        data-collaborator-club-required
                    >
                    @error('club_contact_email')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2" data-collaborator-club-only>
                    <label for="collaborator-contact-phone" class="text-sm font-semibold text-slate-900">
                        Número de teléfono de contacto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-contact-phone"
                        type="tel"
                        name="club_contact_phone"
                        value="{{ old('club_contact_phone') }}"
                        autocomplete="tel"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="600 000 000"
                        data-collaborator-club-required
                    >
                    @error('club_contact_phone')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2">
                    <label for="collaborator-photo" class="text-sm font-semibold text-slate-900" data-collaborator-photo-label>
                        Foto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-photo"
                        type="file"
                        name="photo"
                        accept="image/*"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition file:mr-4 file:rounded-full file:border-0 file:bg-slate-950 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-slate-800 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                    >
                    <p class="text-sm leading-6 text-slate-600" data-collaborator-photo-help>
                        Sube el logo del club para que podamos preparar su ficha.
                    </p>
                    @error('photo')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-referee-only>
                    <label for="collaborator-referee-volleyball-level" class="text-sm font-semibold text-slate-900">
                        Nivel de voleibol
                    </label>
                    <select
                        id="collaborator-referee-volleyball-level"
                        name="referee_volleyball_level"
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                    >
                        <option value="" @selected(old('referee_volleyball_level') === null || old('referee_volleyball_level') === '')>Ninguno</option>
                        <option value="anotador" @selected(old('referee_volleyball_level') === 'anotador')>Anotador</option>
                        <option value="jdm" @selected(old('referee_volleyball_level') === 'jdm')>Árbitro municipal (JDM)</option>
                        <option value="level_1" @selected(old('referee_volleyball_level') === 'level_1')>Nivel 1</option>
                        <option value="level_2" @selected(old('referee_volleyball_level') === 'level_2')>Nivel 2</option>
                        <option value="level_3" @selected(old('referee_volleyball_level') === 'level_3')>Nivel 3</option>
                        <option value="superliga_2" @selected(old('referee_volleyball_level') === 'superliga_2')>Superliga 2</option>
                        <option value="superliga_1" @selected(old('referee_volleyball_level') === 'superliga_1')>Superliga 1</option>
                    </select>
                    @error('referee_volleyball_level')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-referee-only>
                    <label for="collaborator-referee-beach-level" class="text-sm font-semibold text-slate-900">
                        Nivel de voleyplaya
                    </label>
                    <select
                        id="collaborator-referee-beach-level"
                        name="referee_beach_level"
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                    >
                        <option value="" @selected(old('referee_beach_level') === null || old('referee_beach_level') === '')>Ninguno</option>
                        <option value="vp_level_1" @selected(old('referee_beach_level') === 'vp_level_1')>VP Nivel 1</option>
                        <option value="vp_level_2" @selected(old('referee_beach_level') === 'vp_level_2')>VP Nivel 2</option>
                        <option value="vp_level_3" @selected(old('referee_beach_level') === 'vp_level_3')>VP Nivel 3</option>
                    </select>
                    @error('referee_beach_level')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <p class="hidden text-sm text-slate-500" data-collaborator-referee-only>
                    Debes completar al menos uno de los dos niveles.
                </p>

                <div class="grid gap-2 hidden" data-collaborator-referee-only>
                    <label for="collaborator-referee-email" class="text-sm font-semibold text-slate-900">
                        Email de contacto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-referee-email"
                        type="email"
                        name="referee_contact_email"
                        value="{{ old('referee_contact_email') }}"
                        autocomplete="email"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="correo@ejemplo.com"
                        data-collaborator-referee-required
                    >
                    @error('referee_contact_email')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-referee-only>
                    <label for="collaborator-referee-phone" class="text-sm font-semibold text-slate-900">
                        Número de teléfono de contacto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-referee-phone"
                        type="tel"
                        name="referee_contact_phone"
                        value="{{ old('referee_contact_phone') }}"
                        autocomplete="tel"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="600 000 000"
                        data-collaborator-referee-required
                    >
                    @error('referee_contact_phone')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <label class="hidden flex items-start gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4" data-collaborator-referee-only>
                    <input
                        type="checkbox"
                        name="referee_license_confirmation"
                        value="1"
                        required
                        @checked(old('referee_license_confirmation'))
                        class="mt-1 size-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500"
                        data-collaborator-referee-required
                    >
                    <span class="text-sm leading-6 text-slate-700">
                        Asumo que al enviar esto soy un árbitro federado con licencia en vigor. <span class="align-top text-rose-500">*</span>
                    </span>
                </label>
                @error('referee_license_confirmation')
                    <span class="text-sm text-rose-600">{{ $message }}</span>
                @enderror

                <div class="grid gap-2 hidden" data-collaborator-coach-only>
                    <label for="collaborator-coach-volleyball-level" class="text-sm font-semibold text-slate-900">
                        Nivel de voleibol
                    </label>
                    <select
                        id="collaborator-coach-volleyball-level"
                        name="coach_volleyball_level"
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                    >
                        <option value="" @selected(old('coach_volleyball_level') === null || old('coach_volleyball_level') === '')>Ninguno</option>
                        <option value="level_0" @selected(old('coach_volleyball_level') === 'level_0')>Nivel 0</option>
                        <option value="level_1" @selected(old('coach_volleyball_level') === 'level_1')>Nivel 1</option>
                        <option value="level_2" @selected(old('coach_volleyball_level') === 'level_2')>Nivel 2</option>
                        <option value="level_3" @selected(old('coach_volleyball_level') === 'level_3')>Nivel 3</option>
                        <option value="fivb_1" @selected(old('coach_volleyball_level') === 'fivb_1')>FIVB 1</option>
                        <option value="fivb_2" @selected(old('coach_volleyball_level') === 'fivb_2')>FIVB 2</option>
                        <option value="fivb_3" @selected(old('coach_volleyball_level') === 'fivb_3')>FIVB 3</option>
                    </select>
                    @error('coach_volleyball_level')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-coach-only>
                    <label for="collaborator-coach-beach-level" class="text-sm font-semibold text-slate-900">
                        Nivel de voleyplaya
                    </label>
                    <select
                        id="collaborator-coach-beach-level"
                        name="coach_beach_level"
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                    >
                        <option value="" @selected(old('coach_beach_level') === null || old('coach_beach_level') === '')>Ninguno</option>
                        <option value="vp_level_1" @selected(old('coach_beach_level') === 'vp_level_1')>VP Nivel 1</option>
                        <option value="vp_level_2" @selected(old('coach_beach_level') === 'vp_level_2')>VP Nivel 2</option>
                        <option value="vp_level_3" @selected(old('coach_beach_level') === 'vp_level_3')>VP Nivel 3</option>
                    </select>
                    @error('coach_beach_level')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <p class="hidden text-sm text-slate-500" data-collaborator-coach-only>
                    Debes completar al menos uno de los dos niveles.
                </p>

                <div class="grid gap-2 hidden" data-collaborator-coach-only>
                    <label for="collaborator-coach-club" class="text-sm font-semibold text-slate-900">
                        Club principal en el que actualmente entrenas <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-coach-club"
                        type="text"
                        name="coach_main_club"
                        value="{{ old('coach_main_club') }}"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="Nombre oficial del club"
                        data-collaborator-coach-required
                    >
                    @error('coach_main_club')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-coach-only>
                    <label for="collaborator-coach-email" class="text-sm font-semibold text-slate-900">
                        Email de contacto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-coach-email"
                        type="email"
                        name="coach_contact_email"
                        value="{{ old('coach_contact_email') }}"
                        autocomplete="email"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="correo@ejemplo.com"
                        data-collaborator-coach-required
                    >
                    @error('coach_contact_email')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-coach-only>
                    <label for="collaborator-coach-phone" class="text-sm font-semibold text-slate-900">
                        Número de teléfono de contacto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-coach-phone"
                        type="tel"
                        name="coach_contact_phone"
                        value="{{ old('coach_contact_phone') }}"
                        autocomplete="tel"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="600 000 000"
                        data-collaborator-coach-required
                    >
                    @error('coach_contact_phone')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-coach-only>
                    <label for="collaborator-coach-show-club" class="text-sm font-semibold text-slate-900">
                        ¿Quieres mostrar el club en el que entrenas en tu ficha? <span class="align-top text-rose-500">*</span>
                    </label>
                    <select
                        id="collaborator-coach-show-club"
                        name="coach_show_club_on_profile"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        data-collaborator-coach-required
                    >
                        <option value="" @selected(old('coach_show_club_on_profile') === null || old('coach_show_club_on_profile') === '')>Selecciona una opción</option>
                        <option value="yes" @selected(old('coach_show_club_on_profile') === 'yes')>Sí</option>
                        <option value="no" @selected(old('coach_show_club_on_profile') === 'no')>No</option>
                    </select>
                    @error('coach_show_club_on_profile')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <label class="hidden flex items-start gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4" data-collaborator-coach-only>
                    <input
                        type="checkbox"
                        name="coach_license_confirmation"
                        value="1"
                        required
                        @checked(old('coach_license_confirmation'))
                        class="mt-1 size-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500"
                        data-collaborator-coach-required
                    >
                    <span class="text-sm leading-6 text-slate-700">
                        Asumo que al enviar esto soy un entrenador federado con licencia en vigor. <span class="align-top text-rose-500">*</span>
                    </span>
                </label>
                @error('coach_license_confirmation')
                    <span class="text-sm text-rose-600">{{ $message }}</span>
                @enderror

                <div class="grid gap-2 hidden" data-collaborator-player-only>
                    <label for="collaborator-player-division" class="text-sm font-semibold text-slate-900">
                        División en la que juegas <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-player-division"
                        type="text"
                        name="player_division"
                        value="{{ old('player_division') }}"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="División"
                        data-collaborator-player-required
                    >
                    @error('player_division')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-player-only>
                    <label for="collaborator-player-team" class="text-sm font-semibold text-slate-900">
                        Equipo en el que juegas <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-player-team"
                        type="text"
                        name="player_team"
                        value="{{ old('player_team') }}"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="Nombre oficial del club"
                        data-collaborator-player-required
                    >
                    @error('player_team')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-player-only>
                    <label for="collaborator-player-show-team" class="text-sm font-semibold text-slate-900">
                        ¿Quieres que se muestre el equipo en su tarjeta? <span class="align-top text-rose-500">*</span>
                    </label>
                    <select
                        id="collaborator-player-show-team"
                        name="player_show_team_on_profile"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        data-collaborator-player-required
                    >
                        <option value="" @selected(old('player_show_team_on_profile') === null || old('player_show_team_on_profile') === '')>Selecciona una opción</option>
                        <option value="yes" @selected(old('player_show_team_on_profile') === 'yes')>Sí</option>
                        <option value="no" @selected(old('player_show_team_on_profile') === 'no')>No</option>
                    </select>
                    @error('player_show_team_on_profile')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-player-only>
                    <label for="collaborator-player-email" class="text-sm font-semibold text-slate-900">
                        Email de contacto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-player-email"
                        type="email"
                        name="player_contact_email"
                        value="{{ old('player_contact_email') }}"
                        autocomplete="email"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="correo@ejemplo.com"
                        data-collaborator-player-required
                    >
                    @error('player_contact_email')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <div class="grid gap-2 hidden" data-collaborator-player-only>
                    <label for="collaborator-player-phone" class="text-sm font-semibold text-slate-900">
                        Número de teléfono de contacto <span class="align-top text-rose-500">*</span>
                    </label>
                    <input
                        id="collaborator-player-phone"
                        type="tel"
                        name="player_contact_phone"
                        value="{{ old('player_contact_phone') }}"
                        autocomplete="tel"
                        required
                        class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-base text-slate-950 outline-none transition placeholder:text-slate-400 focus:border-slate-300 focus:bg-white focus:ring-4 focus:ring-brand-200/40"
                        placeholder="600 000 000"
                        data-collaborator-player-required
                    >
                    @error('player_contact_phone')
                        <span class="text-sm text-rose-600">{{ $message }}</span>
                    @enderror
                </div>

                <label class="hidden flex items-start gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4" data-collaborator-player-only>
                    <input
                        type="checkbox"
                        name="player_license_confirmation"
                        value="1"
                        required
                        @checked(old('player_license_confirmation'))
                        class="mt-1 size-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500"
                        data-collaborator-player-required
                    >
                    <span class="text-sm leading-6 text-slate-700">
                        Asumo que al enviar esto soy un jugador federado con licencia en vigor. <span class="align-top text-rose-500">*</span>
                    </span>
                </label>
                @error('player_license_confirmation')
                    <span class="text-sm text-rose-600">{{ $message }}</span>
                @enderror

                <label class="flex items-start gap-3 rounded-[1.5rem] border border-slate-200 bg-slate-50 px-4 py-4" data-collaborator-club-only>
                    <input
                        type="checkbox"
                        name="federated_team_confirmation"
                        value="1"
                        required
                        @checked(old('federated_team_confirmation'))
                        class="mt-1 size-4 rounded border-slate-300 text-amber-500 focus:ring-amber-500"
                        data-collaborator-club-required
                    >
                    <span class="text-sm leading-6 text-slate-700">
                        Asumo que el club que estoy enviando tiene algún equipo federado. <span class="align-top text-rose-500">*</span>
                    </span>
                </label>
                @error('federated_team_confirmation')
                    <span class="text-sm text-rose-600">{{ $message }}</span>
                @enderror

                @if ($errors->any())
                    <div class="rounded-[1.5rem] border border-rose-200 bg-rose-50 px-4 py-4 text-sm leading-6 text-rose-900">
                        <p class="font-semibold">Revisa el formulario</p>
                        <ul class="mt-2 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex flex-wrap items-center justify-end gap-3 border-t border-slate-200 pt-5">
                    <button
                        type="button"
                        class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition md:hover:bg-slate-50"
                        data-collaborator-modal-close
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="inline-flex items-center justify-center rounded-full bg-amber-400 px-5 py-3 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300"
                    >
                        Enviar solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
