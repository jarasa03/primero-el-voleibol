@extends('layouts.public')

@section('title', 'Blog')
@section('meta_description', 'Artículos, novedades y publicaciones de Primero el Voleibol.')
@section('body_class', 'page-interior page-blog')

@section('content')
    <section
        id="blog-top"
        class="relative left-1/2 w-screen -translate-x-1/2 -mt-24 overflow-hidden bg-cover bg-center bg-no-repeat text-white sm:-mt-28 lg:-mt-28"
        style="background-image: url('{{ asset('images/blog-hero.webp') }}');"
    >
        <div class="absolute inset-0 bg-slate-950/60"></div>

        <div class="relative mx-auto max-w-[120rem] px-4 pt-20 pb-5 sm:px-6 sm:pt-[5.5rem] sm:pb-12 lg:px-8 lg:pt-24 lg:pb-14">
            <div @class(['grid gap-8 lg:gap-12', 'lg:grid-cols-[1.35fr_0.65fr] lg:items-center' => $featuredPost])>
                <div @class(['flex h-full flex-col justify-center', 'max-w-4xl' => $featuredPost, 'max-w-5xl' => ! $featuredPost])>
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300 sm:text-sm sm:tracking-[0.25em]">Blog</p>
                    <h1 class="mt-2 max-w-3xl text-3xl font-semibold tracking-tight text-white sm:mt-3 sm:text-5xl lg:text-5xl">
                        Noticias, ideas y artículos.
                    </h1>

                    <p class="mt-4 max-w-3xl text-base leading-7 text-brand-200 sm:mt-5 sm:text-xl sm:leading-8">
                        Aquí publicamos nuestras últimas novedades, reflexiones y propuestas para seguir dando
                        forma al proyecto. Baja para ver las entradas más recientes a medida que las publiquemos.
                    </p>
                </div>

                @if ($featuredPost)
                    <aside class="lg:max-w-md lg:justify-self-end">
                        <a href="{{ route('blog.show', $featuredPost) }}" class="group block rounded-[2rem] border border-white/10 bg-white/5 px-4 py-4 shadow-[0_12px_30px_rgba(15,23,42,0.18)] backdrop-blur-sm transition md:hover:bg-white/10 sm:px-6 sm:py-5 lg:px-8 lg:py-5">
                            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Destacado</p>

                            <div class="mt-5">
                                <div class="relative aspect-[4/3] overflow-hidden rounded-[1.5rem] bg-slate-800">
                                    <img src="{{ $featuredPost->featuredImageUrl() }}" alt="{{ $featuredPost->title }}" class="size-full object-cover transition duration-700 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(15,23,42,0)_25%,rgba(15,23,42,0.72)_100%)]"></div>
                                    @if ($featuredPost->isNew())
                                        <span class="absolute left-4 top-4 rounded-full bg-amber-400 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-slate-950">
                                            Nuevo!
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-5">
                                    <p class="text-xs font-semibold uppercase tracking-[0.22em] text-brand-100/75">
                                        {{ $featuredPost->published_at?->format('d/m/Y') }}
                                    </p>
                                    <h2 class="mt-2 text-2xl font-semibold tracking-tight text-white transition group-hover:text-brand-100">
                                        {{ $featuredPost->title }}
                                    </h2>
                                </div>
                            </div>
                        </a>
                    </aside>
                @endif
            </div>
        </div>
    </section>

    <section id="articulos" class="px-4 py-8 sm:px-6 lg:px-8 lg:py-14">
        <div class="mb-4 flex items-end justify-between gap-4 sm:mb-6">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Artículos</p>
                <h2 class="mt-2 text-2xl font-semibold tracking-tight text-slate-950 sm:mt-3 sm:text-4xl">Todas las entradas</h2>
            </div>
        </div>

        @if ($posts->isNotEmpty())
            <div
                class="space-y-6"
                data-blog-feed
                data-next-url="{{ $posts->nextPageUrl() ?? '' }}"
            >
                <div data-blog-feed-list class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                    @include('blog.partials.post-cards', ['posts' => $posts])
                </div>

                <div class="flex justify-center">
                    <a
                        href="#blog-top"
                        data-blog-feed-status-end
                        class="hidden w-fit items-center gap-2 rounded-full border border-brand-200 bg-brand-50 px-4 py-2 font-semibold text-brand-800 shadow-sm transition hover:border-brand-300 hover:bg-brand-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-brand-500 focus-visible:ring-offset-2"
                    >
                        <span>Volver arriba</span>
                        <span aria-hidden="true">&#8593;</span>
                    </a>
                </div>

                @if ($posts->nextPageUrl())
                    <noscript>
                        <div class="flex justify-center">
                            <a href="{{ $posts->nextPageUrl() }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm">
                                Ver más artículos
                            </a>
                        </div>
                    </noscript>
                @endif

                <div data-blog-feed-sentinel aria-hidden="true" class="h-1"></div>
            </div>
        @else
            <div class="rounded-[2rem] border border-dashed border-slate-200 bg-slate-50 px-4 py-8 text-center sm:px-6 sm:py-10 lg:px-8">
                <p class="text-sm font-semibold uppercase tracking-[0.22em] text-slate-500">Sin artículos</p>
                <p class="mt-3 text-base leading-7 text-slate-600">
                    Todavía no hay entradas publicadas en el blog.
                </p>
            </div>
        @endif
    </section>
@endsection
