@extends('layouts.public')

@section('title', 'Primero el Voleibol')
@section('meta_description', 'Un movimiento para escuchar, proponer y construir el futuro del voleibol madrileño desde la pista, los clubes y las personas que lo hacen posible.')

@section('content')
    <section class="pb-8 pt-8 lg:pb-10 lg:pt-10">
        <div class="relative overflow-hidden rounded-[2.25rem] bg-slate-950 px-6 py-10 text-white shadow-[0_28px_80px_rgba(15,23,42,0.24)] sm:px-8 lg:px-10 lg:py-12">
            <div class="pointer-events-none absolute inset-0">
                <div
                    class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-25 mix-blend-soft-light"
                    style="background-image: url('https://source.unsplash.com/featured/1600x900/?volleyball%2Ccourt%2Csport');"
                ></div>
                <div class="absolute inset-0 bg-[linear-gradient(118deg,rgba(15,23,42,0.97)_8%,rgba(15,23,42,0.84)_42%,rgba(15,23,42,0.58)_100%)]"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(251,191,36,0.20),transparent_42%)]"></div>
                <div class="absolute inset-x-0 bottom-0 h-px bg-white/10"></div>
            </div>

            <div class="relative grid gap-8 lg:grid-cols-[1.1fr_0.9fr] lg:items-start">
                <div class="max-w-3xl lg:pt-2">
                    <p class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-sm font-medium text-brand-100">
                        <span class="size-2 rounded-full bg-amber-400"></span>
                        Movimiento cívico y deportivo en Madrid
                    </p>

                    <h1 class="mt-6 max-w-2xl text-5xl font-semibold tracking-tight text-white sm:text-6xl lg:text-7xl">
                        Primero el voleibol.
                        <span class="block text-brand-100">Madrid merece más.</span>
                    </h1>

                    <p class="mt-6 max-w-2xl text-lg leading-8 text-brand-200 sm:text-xl">
                        Un movimiento para escuchar, proponer y construir el futuro del voleibol madrileño desde la pista, los clubes y las personas que lo hacen posible.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-4">
                        <a href="{{ route('participa') }}" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300">
                            Participa
                        </a>
                        <a href="{{ route('contacto') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-white/10">
                            Escríbenos
                        </a>
                    </div>

                    <p class="mt-8 max-w-2xl border-l-4 border-amber-400 pl-4 text-xl font-medium leading-9 text-white">
                        El voleibol madrileño merece estar donde le corresponde.
                    </p>
                </div>

                <aside class="lg:justify-self-end">
                    <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6 shadow-[0_12px_30px_rgba(15,23,42,0.18)]">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Qué queremos hacer</p>
                        <div class="mt-5 grid gap-3">
                            <div class="rounded-2xl border border-white/10 bg-slate-900/40 p-4">
                                <p class="text-base font-semibold text-white">Escuchar a la pista</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Recoger la voz de clubes, jugadores, entrenadores, árbitros y familias.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/30 p-4">
                                <p class="text-base font-semibold text-white">Ordenar el debate</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Convertir ideas sueltas en propuestas concretas, viables y útiles.
                                </p>
                            </div>
                            <div class="rounded-2xl border border-white/10 bg-slate-900/20 p-4">
                                <p class="text-base font-semibold text-white">Abrir futuro</p>
                                <p class="mt-2 text-sm leading-6 text-brand-100/80">
                                    Pensar un proyecto ambicioso, abierto y a largo plazo para Madrid.
                                </p>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    <section id="proyecto" class="py-10 lg:py-14">
        <div class="mb-6 flex items-end justify-between gap-4">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Proyecto</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">Una base clara para hablar de voleibol</h2>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="size-3 rounded-full bg-amber-400"></span>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Escuchar</p>
                </div>
                <h3 class="mt-5 text-xl font-semibold text-slate-950">La voz de la pista</h3>
                <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                    Queremos recoger la voz de clubes, jugadores, entrenadores, árbitros y familias. Las mejores ideas nacen de quienes viven el voleibol cada semana.
                </p>
            </article>

            <article id="principios" class="rounded-[1.75rem] border border-slate-200 bg-slate-100 p-6 shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="size-3 rounded-full bg-slate-700"></span>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Proponer</p>
                </div>
                <h3 class="mt-5 text-xl font-semibold text-slate-950">Rigor y utilidad</h3>
                <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                    No basta con quejarse. Queremos ordenar propuestas concretas, viables y útiles para mejorar el voleibol madrileño.
                </p>
            </article>

            <article id="participa" class="rounded-[1.75rem] border border-slate-900 bg-slate-950 p-6 text-white shadow-[0_18px_40px_rgba(15,23,42,0.18)]">
                <div class="flex items-center gap-3">
                    <span class="size-3 rounded-full bg-amber-400"></span>
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-100/80">Construir</p>
                </div>
                <h3 class="mt-5 text-xl font-semibold text-white">Un futuro compartido</h3>
                <p class="mt-3 text-[1rem] leading-7 text-brand-200">
                    Madrid tiene talento, clubes y personas. Ahora necesita un proyecto ambicioso, abierto y pensado a largo plazo.
                </p>
            </article>
        </div>
    </section>

    <section id="programa" class="py-10 lg:py-14">
        <div class="rounded-[2rem] border border-slate-200 bg-white px-6 py-8 shadow-sm sm:px-8 lg:px-10 lg:py-10">
            <div class="grid gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:items-start">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Programa</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Una base para ir sumando ideas
                    </h2>
                    <p class="mt-4 max-w-xl text-lg leading-8 text-slate-700">
                        Este apartado ira creciendo con nuevas propuestas. Empezamos por tres medidas concretas que
                        queremos poner sobre la mesa para abrir debate y mejorar el voleibol madrileño.
                    </p>
                </div>

                <div class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6 shadow-[0_10px_30px_rgba(15,23,42,0.05)]">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500">La idea es sencilla</p>
                    <p class="mt-4 text-base leading-7 text-slate-700">
                        Medidas claras, comprensibles y aplicables. Queremos que el programa no sea un documento
                        cerrado, sino un espacio vivo donde ir incorporando propuestas con sentido.
                    </p>
                </div>
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                <article class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6">
                    <div class="flex items-center gap-3">
                        <span class="size-3 rounded-full bg-amber-400"></span>
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">01</p>
                    </div>
                    <h3 class="mt-5 text-xl font-semibold tracking-tight text-slate-950">
                        Tarjetas con consecuencias
                    </h3>
                    <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                        Cada 4 tarjetas amarillas, o cada 2 rojas, debería haber 1 partido de suspensión. Una
                        expulsión debería suponer 2 partidos de suspensión y una descalificación, 4 partidos.
                    </p>
                </article>

                <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center gap-3">
                        <span class="size-3 rounded-full bg-slate-700"></span>
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">02</p>
                    </div>
                    <h3 class="mt-5 text-xl font-semibold tracking-tight text-slate-950">
                        Formación anual obligatoria
                    </h3>
                    <p class="mt-3 text-[1rem] leading-7 text-slate-600">
                        Los árbitros deberían realizar al menos una reunión anual para informar de cambios,
                        criterios de temporada y directrices comunes.
                    </p>
                </article>

                <article class="rounded-[1.75rem] border border-slate-900 bg-slate-950 p-6 text-white shadow-[0_18px_40px_rgba(15,23,42,0.18)]">
                    <div class="flex items-center gap-3">
                        <span class="size-3 rounded-full bg-amber-400"></span>
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-100/80">03</p>
                    </div>
                    <h3 class="mt-5 text-xl font-semibold tracking-tight text-white">
                        Feedback entre niveles
                    </h3>
                    <p class="mt-3 text-[1rem] leading-7 text-brand-200">
                        A los árbitros de mayor nivel se les podría pedir que elaboren informes sobre árbitros de
                        menor nivel, para acompañar su mejora durante toda la temporada.
                    </p>
                </article>
            </div>

            <div class="mt-8 rounded-[1.75rem] border border-slate-200 bg-slate-100 px-6 py-6 sm:px-8">
                <div class="grid gap-4 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.22em] text-accent-700">Aporta más</p>
                        <p class="mt-2 max-w-2xl text-base leading-7 text-slate-700">
                            Si ves otra medida que debería entrar en el programa, nos encantaría leerla. Queremos
                            que este espacio crezca con ideas útiles y bien pensadas.
                        </p>
                    </div>

                    <a href="{{ route('contacto') }}" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-3 text-sm font-semibold text-white transition md:hover:bg-slate-800">
                        Escríbenos
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="blog" class="py-10 lg:py-14">
        <div class="grid gap-6 rounded-[2rem] border border-slate-200 bg-white p-6 shadow-sm lg:grid-cols-[0.8fr_1.2fr] lg:p-8">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-slate-500">Blog</p>
                <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950">Seguimos abriendo conversación</h2>
            </div>

            <p class="max-w-3xl text-lg leading-8 text-slate-700">
                Pronto publicaremos novedades, propuestas y contenido para seguir abriendo conversación alrededor del voleibol madrileño.
            </p>
        </div>
    </section>

    <section id="contacto" class="py-10 lg:py-14">
        <div class="rounded-[2.25rem] bg-slate-950 px-6 py-8 text-white shadow-[0_22px_60px_rgba(15,23,42,0.22)] sm:px-8 lg:px-10 lg:py-10">
            <div class="grid gap-8 lg:grid-cols-[1.2fr_0.8fr] lg:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Contacto</p>
                    <p class="mt-4 max-w-2xl text-lg leading-8 text-brand-200">
                        Si quieres escribirnos, compartir una idea o empezar a sumar, estamos aquí.
                    </p>
                </div>

                <div class="lg:justify-self-end">
                    <a href="mailto:info@primeroelvoleibol.es" class="inline-flex w-full items-center justify-center rounded-full border border-white/15 bg-white/5 px-6 py-3 text-sm font-semibold text-white transition md:hover:bg-white/10 sm:w-auto">
                        info@primeroelvoleibol.es
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
