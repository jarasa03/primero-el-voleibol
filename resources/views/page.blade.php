@extends('layouts.public')

@section('title', $title)
@section('meta_description', $description)
@section('body_class', 'page-interior')

@section('content')
    @if (! empty($show_hero))
        @php($heroImage = $hero_image ?? asset('images/programa-hero.webp'))

        <section
            class="relative left-1/2 w-screen -translate-x-1/2 -mt-24 overflow-hidden bg-cover bg-center bg-no-repeat text-white sm:-mt-28 lg:-mt-28"
            style="background-image: url('{{ $heroImage }}');"
        >
            <div class="absolute inset-0 bg-slate-950/70"></div>

            <div class="relative mx-auto max-w-7xl px-4 pt-20 pb-5 sm:px-0 sm:pt-[5.5rem] sm:pb-12 lg:pt-24 lg:pb-14">
                <div class="flex h-full max-w-4xl flex-col justify-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">{{ $eyebrow }}</p>
                    <h1 class="mt-2 max-w-3xl text-3xl font-semibold tracking-tight text-white sm:mt-3 sm:text-5xl lg:text-5xl">
                        {{ $title }}
                    </h1>

                    <p class="mt-4 max-w-3xl text-base leading-7 text-brand-200 sm:mt-5 sm:text-xl sm:leading-8">
                        {{ $intro }}
                    </p>

                    <div class="mt-6 flex flex-wrap gap-3 sm:mt-7">
                        <a href="#contenido" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-5 py-2.5 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300 sm:px-6 sm:py-3">
                            Ver contenido
                        </a>
                        <a href="{{ route('participa') }}" class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-5 py-2.5 text-sm font-semibold text-white transition md:hover:bg-white/10 sm:px-6 sm:py-3">
                            Aportar una idea
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="contenido" class="py-10 lg:py-14">
            <div class="grid gap-6 lg:grid-cols-[0.8fr_1.2fr]">
                <div class="rounded-[2rem] border border-slate-200 bg-white px-6 py-8 shadow-sm sm:px-8 lg:px-10 lg:py-10">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">{{ $eyebrow }}</p>
                    <h2 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                        Lorem ipsum dolor sit amet
                    </h2>
                    <p class="mt-4 text-lg leading-8 text-slate-700">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                </div>

                <div class="grid gap-6">
                    <article class="rounded-[1.75rem] border border-slate-200 bg-slate-50 p-6">
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-amber-400"></span>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">01</p>
                        </div>
                        <h3 class="mt-5 text-xl font-semibold tracking-tight text-slate-950">
                            Lorem ipsum
                        </h3>
                        <p class="mt-3 max-w-2xl text-[1rem] leading-7 text-slate-600">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore.
                        </p>
                    </article>

                    <article class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-slate-700"></span>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">02</p>
                        </div>
                        <h3 class="mt-5 text-xl font-semibold tracking-tight text-slate-950">
                            Lorem ipsum
                        </h3>
                        <p class="mt-3 max-w-2xl text-[1rem] leading-7 text-slate-600">
                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                    </article>

                    <article class="rounded-[1.75rem] border border-slate-900 bg-slate-950 p-6 text-white shadow-[0_18px_40px_rgba(15,23,42,0.18)]">
                        <div class="flex items-center gap-3">
                            <span class="size-3 rounded-full bg-amber-400"></span>
                            <p class="text-sm font-semibold uppercase tracking-[0.22em] text-brand-100/80">03</p>
                        </div>
                        <h3 class="mt-5 text-xl font-semibold tracking-tight text-white">
                            Lorem ipsum
                        </h3>
                        <p class="mt-3 max-w-2xl text-[1rem] leading-7 text-brand-200">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                        </p>
                    </article>
                </div>
            </div>
        </section>
    @else
        <section class="py-10 lg:py-14">
            <div class="rounded-[2rem] border border-slate-200 bg-white px-6 py-8 shadow-sm sm:px-8 lg:px-10 lg:py-10">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">{{ $eyebrow }}</p>
                <h1 class="mt-3 text-3xl font-semibold tracking-tight text-slate-950 sm:text-4xl">
                    {{ $title }}
                </h1>
                <p class="mt-4 max-w-3xl text-lg leading-8 text-slate-700">
                    {{ $intro }}
                </p>

                <div class="mt-8 rounded-[1.75rem] border border-dashed border-slate-200 bg-slate-50 px-6 py-10 text-center sm:px-8">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Contenido en construccion</p>
                    <p class="mt-3 text-base leading-7 text-slate-600">
                        Este espacio esta preparado para crecer con contenido propio.
                    </p>
                </div>
            </div>
        </section>
    @endif
@endsection
