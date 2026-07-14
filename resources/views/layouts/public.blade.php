<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('meta_description', 'Primero el Voleibol es un proyecto cÃ­vico y deportivo en Madrid para poner el voleibol en el centro de la ciudad.')">

        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="alternate icon" href="{{ asset('favicon.ico') }}">

        <title>@yield('title', config('app.name'))</title>

        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased" data-nav-scrolled="false">
        <div class="relative min-h-screen overflow-hidden bg-slate-50 text-slate-950">
            <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-slate-200"></div>

            <div class="relative mx-auto flex min-h-screen w-full max-w-7xl flex-col px-4 sm:px-6 lg:px-8">
                <header class="fixed inset-x-0 top-0 z-50 px-4 pt-4 sm:px-6 lg:px-8">
                    <div class="site-header-shell mx-auto flex max-w-7xl items-center justify-between gap-6 rounded-[1.5rem] border px-4 py-3 transition-[background-color,border-color,box-shadow,transform,opacity] duration-500 ease-in-out">
                        <a href="{{ url('/') }}" class="group inline-flex items-center gap-3">
                            <span class="site-header-logo grid size-11 place-items-center rounded-2xl border border-slate-200 bg-white text-sm font-bold tracking-[0.22em] transition-[background-color,border-color,color,box-shadow,transform]">
                                PV
                            </span>
                            <span class="flex flex-col leading-tight">
                                <span class="site-header-brand text-sm font-semibold uppercase tracking-[0.35em] transition-colors duration-500 ease-in-out">Primero el Voleibol</span>
                                <span class="site-header-subtitle text-xs transition-colors duration-500 ease-in-out">Llevemos el voleibol madrileño donde merece estar.</span>
                            </span>
                        </a>

                        <nav class="site-header-nav hidden items-center gap-6 text-sm font-medium md:flex">
                            <a class="site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out hover:text-slate-950" href="#proyecto">Proyecto</a>
                            <a class="site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out hover:text-slate-950" href="#principios">Principios</a>
                            <a class="site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out hover:text-slate-950" href="#programa">Programa</a>
                            <a class="site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out hover:text-slate-950" href="#propuestas">Propuestas</a>
                            <a class="site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out hover:text-slate-950" href="#actualidad">Actualidad</a>
                            <a class="site-header-link transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out hover:text-slate-950" href="#participa">Participa</a>
                            <a class="site-header-cta rounded-full border border-slate-200 bg-white px-4 py-2 transition-[color,background-color,border-color,box-shadow,opacity] duration-500 ease-in-out hover:border-slate-300 hover:bg-slate-50" href="#contacto">Contacto</a>
                        </nav>
                    </div>
                </header>

                <main class="flex-1">
                    @yield('content')
                </main>

                <footer class="py-10 text-sm text-slate-500">
                    <div class="flex flex-col gap-4 border-t border-slate-200 pt-6 md:flex-row md:items-center md:justify-between">
                        <p>Primero el Voleibol · Madrid</p>
                        <p>Llevemos el voleibol madrileño donde merece estar.</p>
                    </div>
                </footer>
            </div>
        </div>
    </body>
</html>
