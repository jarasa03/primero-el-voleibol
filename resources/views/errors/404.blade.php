@extends('layouts.public')

@section('title', 'Error 404 · Primero el Voleibol')
@section('meta_description', 'La página que buscas no está disponible.')
@section('error_page', 'true')
@section('body_class', 'page-legal page-error')

@section('content')
    <section class="relative -mx-4 flex w-[calc(100%+2rem)] min-w-0 flex-1 flex-col justify-center overflow-hidden rounded-none bg-brand-950 px-5 py-5 text-white shadow-none sm:mx-auto sm:w-full sm:flex-none sm:max-w-5xl sm:rounded-[1.5rem] sm:px-8 sm:py-8 sm:shadow-[0_18px_50px_rgba(15,23,42,0.16)] lg:px-10 lg:py-9">
        <div class="relative grid items-center gap-7 sm:gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(17rem,0.72fr)] lg:gap-12">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300 sm:text-sm">Error 404</p>
                <h1 class="mt-2 max-w-xl text-2xl font-semibold leading-tight tracking-tight text-white sm:text-4xl lg:text-5xl">
                    Esta jugada se ha ido fuera.
                </h1>
                <p class="mt-3 max-w-lg text-sm leading-5 text-brand-100/80 sm:text-base sm:leading-7">
                    La página que buscas no existe, ha cambiado de dirección o ya no está disponible.
                </p>

                <div class="mt-5 flex flex-col gap-2.5 sm:flex-row sm:flex-wrap">
                    <a href="{{ route('home') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-full bg-amber-400 px-5 py-3 text-sm font-semibold text-slate-950 transition-colors hover:bg-amber-300 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-200 focus-visible:ring-offset-4 focus-visible:ring-offset-brand-950 sm:w-auto sm:px-6">
                        Volver al inicio
                        <svg viewBox="0 0 20 20" fill="none" aria-hidden="true" class="size-4">
                            <path d="M4 10h11m-4.5-4.5L15 10l-4.5 4.5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                    <a href="{{ route('programa') }}" class="inline-flex w-full items-center justify-center rounded-full border border-white/20 bg-white/5 px-5 py-3 text-sm font-semibold text-white transition-colors hover:border-white/40 hover:bg-white/10 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-amber-300 focus-visible:ring-offset-4 focus-visible:ring-offset-brand-950 sm:w-auto sm:px-6">
                        Ver propuestas
                    </a>
                </div>
            </div>

            <div class="relative flex min-h-20 items-center justify-center sm:min-h-32 lg:min-h-40" aria-hidden="true">
                <span class="absolute select-none text-[clamp(6rem,28vw,8rem)] font-bold leading-none tracking-[-0.14em] text-brand-700/60 sm:text-[clamp(7rem,18vw,11rem)]">404</span>
                <div class="relative grid grid-cols-[1fr_auto_1fr] items-center gap-3 text-5xl font-semibold leading-none tracking-[-0.1em] text-brand-100 sm:gap-5 sm:text-7xl">
                    <span class="justify-self-end">4</span>
                    <img src="{{ asset('favicon.svg') }}" alt="" class="size-9 rounded-lg sm:size-14" aria-hidden="true">
                    <span class="-ml-2 justify-self-start sm:-ml-3">4</span>
                </div>
            </div>
        </div>
    </section>
@endsection
