@extends('layouts.public')

@section('title', $blogPost->title)
@section('meta_description', $blogPost->excerpt(160))
@section('body_class', 'page-interior page-blog')

@section('content')
    <article class="pb-8 lg:pb-10">
        <section
            id="blog-top"
            class="relative left-1/2 w-screen -translate-x-1/2 -mt-24 overflow-hidden bg-cover bg-center bg-no-repeat text-white sm:-mt-28 lg:-mt-28"
            style="background-image: url('{{ $blogPost->featuredImageUrl() }}');"
        >
            <div class="absolute inset-0 bg-slate-950/60"></div>

            <div class="relative mx-auto max-w-7xl pt-20 pb-10 sm:pt-[5.5rem] sm:pb-12 lg:pt-24 lg:pb-14">
                <div class="flex h-full max-w-4xl flex-col justify-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-amber-300">Blog</p>
                    <h1 class="mt-3 max-w-3xl text-4xl font-semibold tracking-tight text-white sm:text-5xl lg:text-5xl">
                        {{ $blogPost->title }}
                    </h1>

                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('blog') }}" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-6 py-3 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300">
                            Volver al blog
                        </a>
                        @if ($blogPost->isNew())
                            <span class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-6 py-3 text-sm font-semibold text-white">
                                Nuevo!
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        @php($hasAttachments = ! empty($attachments))

        <div @class(['mt-8 grid gap-8', 'lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-start' => $hasAttachments])>
            <div class="min-w-0 w-full">
                <div class="blog-content max-w-none">
                    {!! \Filament\Forms\Components\RichEditor\RichContentRenderer::make($blogPost->renderedContent())
                        ->fileAttachmentsDisk('public')
                        ->fileAttachmentsVisibility('public')
                        ->toHtml() !!}
                </div>
            </div>

            @if ($hasAttachments)
                <aside class="space-y-6">
                    <div class="rounded-[2rem] border border-slate-200 bg-slate-50 px-6 py-6 shadow-sm">
                        <p class="text-sm font-semibold uppercase tracking-[0.25em] text-accent-700">Adjuntos</p>
                        <p class="mt-3 text-sm leading-6 text-slate-600">
                            Archivos asociados a este artículo. Puedes abrirlos en una nueva pestaña.
                        </p>

                        <div class="mt-5 space-y-3">
                            @foreach ($attachments as $attachment)
                                <a
                                    href="{{ $attachment['url'] }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="flex items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-white px-4 py-3 text-left shadow-sm transition md:hover:border-slate-300 md:hover:bg-slate-50"
                                >
                                    <span class="min-w-0">
                                        <span class="block truncate text-sm font-semibold text-slate-950">
                                            {{ $attachment['name'] }}
                                        </span>
                                        <span class="mt-1 block text-xs uppercase tracking-[0.22em] text-slate-500">
                                            {{ strtoupper($attachment['extension']) }}
                                        </span>
                                    </span>

                                    <span class="shrink-0 text-sm font-semibold text-brand-700">
                                        Abrir
                                    </span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </aside>
            @endif
        </div>
    </article>
@endsection
