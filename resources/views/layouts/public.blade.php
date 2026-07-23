<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('meta_description', 'Primero el Voleibol es un proyecto civico y deportivo en Madrid para poner el voleibol en el centro de la ciudad.')">

        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

        <title>@yield('title', config('app.name'))</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('head')
    </head>
    <body class="antialiased @yield('body_class')" data-nav-scrolled="false">
        @php
            $isProyectoActive = request()->routeIs('proyecto');
            $isPrincipiosActive = request()->routeIs('principios');
            $isProgramaActive = request()->routeIs('programa');
            $isBlogActive = request()->routeIs('blog*');
            $isWidePage = request()->routeIs('home') || request()->routeIs('programa') || request()->routeIs('blog*') || request()->routeIs('participa');
            $activeNavLinkStyle = 'color: rgb(252 211 77) !important;';
        @endphp

        <div class="relative min-h-screen overflow-x-hidden bg-slate-50 text-slate-950">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-slate-200"></div>

            <header class="site-header-band fixed inset-x-0 top-0 z-50">
                <div class="mx-auto flex h-full w-full max-w-[120rem] items-center py-3 sm:py-4">
                    <div class="site-header-shell flex w-full items-center justify-between gap-4 px-4 py-0 sm:px-6 sm:gap-6 lg:px-8">
                        <a href="{{ url('/') }}" class="group inline-flex min-w-0 items-center gap-2 sm:gap-3">
                            <span class="site-header-logo grid size-11 aspect-square shrink-0 place-items-center rounded-2xl border border-slate-200 bg-white text-[0.78rem] font-bold leading-none tracking-[0.22em] transition-[background-color,border-color,color,box-shadow,transform] sm:size-12 sm:text-sm">
                                PV
                            </span>
                            <span class="flex min-w-0 flex-col leading-tight">
                                <span class="site-header-brand truncate text-[0.72rem] font-semibold uppercase tracking-[0.18em] transition-colors duration-500 ease-in-out sm:text-sm sm:tracking-[0.35em]">Primero el Voleibol</span>
                                <span class="site-header-subtitle hidden text-xs transition-colors duration-500 ease-in-out sm:block">Llevemos el voleibol madrileño donde merece estar.</span>
                            </span>
                        </a>

                        <nav class="site-header-nav hidden items-center gap-6 text-sm font-medium md:flex">
                            <a @class([
                                'site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out',
                                'site-header-link--active text-amber-300' => $isProyectoActive,
                                'md:hover:text-slate-950' => ! $isProyectoActive,
                            ]) style="{{ $isProyectoActive ? $activeNavLinkStyle : '' }}" href="{{ route('proyecto') }}">Proyecto</a>
                            <a @class([
                                'site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out',
                                'site-header-link--active text-amber-300' => $isPrincipiosActive,
                                'md:hover:text-slate-950' => ! $isPrincipiosActive,
                            ]) style="{{ $isPrincipiosActive ? $activeNavLinkStyle : '' }}" href="{{ route('principios') }}">Principios</a>
                            <a @class([
                                'site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out',
                                'site-header-link--active text-amber-300' => $isProgramaActive,
                                'md:hover:text-slate-950' => ! $isProgramaActive,
                            ]) style="{{ $isProgramaActive ? $activeNavLinkStyle : '' }}" href="{{ route('programa') }}">Programa</a>
                            <a @class([
                                'site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out',
                                'site-header-link--active text-amber-300' => $isBlogActive,
                                'md:hover:text-slate-950' => ! $isBlogActive,
                            ]) style="{{ $isBlogActive ? $activeNavLinkStyle : '' }}" href="{{ route('blog') }}">Blog</a>
                            <a @class([
                                'site-header-cta rounded-full border border-slate-200 bg-white px-4 py-2 transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out md:hover:border-slate-300 md:hover:bg-slate-50 text-slate-950',
                            ]) href="{{ route('participa') }}">Participa</a>
                        </nav>

                        <button
                            type="button"
                            class="site-header-toggle inline-flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-3 py-3 text-slate-900 transition-[background-color,border-color,color,box-shadow,opacity] duration-500 ease-in-out md:hidden"
                            aria-controls="mobile-navigation"
                            aria-expanded="false"
                            data-nav-toggle
                        >
                            <span class="sr-only">Abrir menú</span>
                            <span class="site-header-toggle-icon relative block size-6">
                                <span class="site-header-toggle-bar absolute left-0 top-1/2 block h-0.5 w-6 -translate-y-1/2 rounded-full bg-slate-900 transition-transform duration-500 ease-in-out"></span>
                                <span class="site-header-toggle-bar absolute left-0 top-1/2 block h-0.5 w-6 -translate-y-1/2 rounded-full bg-slate-900 transition-transform duration-500 ease-in-out"></span>
                                <span class="site-header-toggle-bar absolute left-0 top-1/2 block h-0.5 w-6 -translate-y-1/2 rounded-full bg-slate-900 transition-transform duration-500 ease-in-out"></span>
                            </span>
                        </button>
                    </div>
                </div>

                <div id="mobile-navigation" aria-hidden="true" class="site-mobile-nav relative z-50 border-t md:hidden">
                    <div class="mx-auto w-full max-w-[120rem] px-4 py-4 sm:px-6 lg:px-8">
                        <nav class="flex flex-col gap-2 text-sm font-medium">
                            <a @class([
                                'site-header-link rounded-2xl px-4 py-3 transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out',
                                'site-header-link--active text-amber-300' => $isProyectoActive,
                                'md:hover:text-slate-950' => ! $isProyectoActive,
                            ]) style="{{ $isProyectoActive ? $activeNavLinkStyle : '' }}" href="{{ route('proyecto') }}">Proyecto</a>
                            <a @class([
                                'site-header-link rounded-2xl px-4 py-3 transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out',
                                'site-header-link--active text-amber-300' => $isPrincipiosActive,
                                'md:hover:text-slate-950' => ! $isPrincipiosActive,
                            ]) style="{{ $isPrincipiosActive ? $activeNavLinkStyle : '' }}" href="{{ route('principios') }}">Principios</a>
                            <a @class([
                                'site-header-link rounded-2xl px-4 py-3 transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out',
                                'site-header-link--active text-amber-300' => $isProgramaActive,
                                'md:hover:text-slate-950' => ! $isProgramaActive,
                            ]) style="{{ $isProgramaActive ? $activeNavLinkStyle : '' }}" href="{{ route('programa') }}">Programa</a>
                            <a @class([
                                'site-header-link rounded-2xl px-4 py-3 transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out',
                                'site-header-link--active text-amber-300' => $isBlogActive,
                                'md:hover:text-slate-950' => ! $isBlogActive,
                            ]) style="{{ $isBlogActive ? $activeNavLinkStyle : '' }}" href="{{ route('blog') }}">Blog</a>
                            <a @class([
                                'site-header-cta mt-2 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-center text-slate-950 transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out md:hover:border-slate-300 md:hover:bg-slate-50',
                            ]) href="{{ route('participa') }}">Participa</a>
                        </nav>
                    </div>
                </div>
            </header>

            <div class="relative mx-auto flex min-h-screen w-full flex-col px-4 pt-24 sm:px-6 sm:pt-28 lg:px-8 lg:pt-28">
                <main class="flex-1">
                    <div @class(['mx-auto w-full', 'max-w-[120rem]' => $isWidePage, 'max-w-7xl' => ! $isWidePage])>
                        @yield('content')
                    </div>
                </main>
            </div>

            <footer class="mt-6 overflow-hidden bg-slate-950 text-white shadow-[0_-20px_60px_rgba(15,23,42,0.12)] sm:mt-8">
                <div class="relative">
                    <div class="mx-auto w-full max-w-[120rem] px-4 sm:px-6 lg:px-8">
                        <div class="relative overflow-hidden rounded-[2.5rem]">
                            <div class="relative grid gap-10 py-10 sm:py-12 lg:grid-cols-[1.2fr_0.8fr] lg:gap-12 lg:py-12">
                                <div class="max-w-2xl">
                                    <div class="inline-flex items-center gap-3 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-amber-300">
                                        <span class="size-2 rounded-full bg-amber-400"></span>
                                        Primero el Voleibol
                                    </div>

                                    <h2 class="mt-5 text-3xl font-semibold tracking-tight text-white sm:text-4xl">
                                        Sigamos poniendo el voleibol en el centro.
                                    </h2>

                                    <p class="mt-4 max-w-xl text-base leading-7 text-brand-100/80 sm:text-lg">
                                        Queremos escuchar a la pista, ordenar ideas y convertirlas en propuestas &uacute;tiles para el voleibol madrile&ntilde;o.
                                    </p>

                                    <div class="mt-7 flex flex-wrap gap-3">
                                        <a href="{{ route('participa') }}" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-5 py-3 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300">
                                            Escr&#237;benos
                                        </a>
                                        <a href="{{ route('blog') }}" class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition md:hover:bg-white/10">
                                            Ver blog
                                        </a>
                                    </div>
                                </div>

                                <div class="py-0 sm:py-6">
                                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Navegaci&oacute;n</p>

                                    <div class="mt-5 grid grid-cols-2 gap-6 sm:gap-8 sm:items-start">
                                        <div class="sm:pr-4">
                                            <p class="text-sm font-medium text-white">Explora</p>
                                            <ul class="mt-4 space-y-3 text-sm text-brand-100/80">
                                                <li><a class="transition md:hover:text-amber-300" href="{{ route('proyecto') }}">Proyecto</a></li>
                                                <li><a class="transition md:hover:text-amber-300" href="{{ route('principios') }}">Principios</a></li>
                                                <li><a class="transition md:hover:text-amber-300" href="{{ route('programa') }}">Programa</a></li>
                                                <li><a class="transition md:hover:text-amber-300" href="{{ route('blog') }}">Blog</a></li>
                                            </ul>
                                        </div>

                                        <div class="sm:pl-4 sm:text-right">
                                            <p class="text-sm font-medium text-white">Hablemos</p>
                                            <ul class="mt-4 space-y-3 text-sm text-brand-100/80 sm:inline-block">
                                                <li><a class="transition md:hover:text-amber-300" href="{{ route('participa') }}">Escríbenos</a></li>
                                                <li><a class="transition md:hover:text-amber-300" href="mailto:info@primeroelvoleibol.es">info@primeroelvoleibol.es</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="relative border-t border-white/10 px-4 py-5 text-sm text-brand-100/70 sm:px-6 lg:px-8">
                                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                    <p>Primero el Voleibol - Madrid</p>
                                    <div class="flex flex-wrap gap-x-5 gap-y-2">
                                        <a class="transition md:hover:text-amber-300" href="{{ route('legal.aviso-legal') }}">Aviso legal</a>
                                        <a class="transition md:hover:text-amber-300" href="{{ route('legal.politica-de-privacidad') }}">Pol&iacute;tica de privacidad</a>
                                        <a class="transition md:hover:text-amber-300" href="{{ route('legal.politica-de-cookies') }}">Pol&iacute;tica de cookies</a>
                                    </div>
                                    <p>{{ now()->year }} - Hecho para poner el voleibol en el centro</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
