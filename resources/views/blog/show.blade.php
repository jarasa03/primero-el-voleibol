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

            <div class="relative mx-auto max-w-[120rem] px-4 pt-20 pb-5 sm:px-6 sm:pt-[5.5rem] sm:pb-12 lg:px-8 lg:pt-24 lg:pb-14">
                <div class="flex h-full max-w-4xl flex-col justify-center">
                    <p class="text-xs font-semibold uppercase tracking-[0.28em] text-amber-300 sm:text-sm sm:tracking-[0.25em]">Blog</p>
                    <h1 class="mt-2 max-w-3xl text-3xl font-semibold tracking-tight text-white sm:mt-3 sm:text-5xl lg:text-5xl">
                        {{ $blogPost->title }}
                    </h1>

                    <div class="mt-6 flex flex-wrap gap-3 sm:mt-7">
                        <a href="{{ route('blog') }}" class="inline-flex items-center justify-center rounded-full bg-amber-400 px-5 py-2.5 text-sm font-semibold text-slate-950 transition md:hover:bg-amber-300 sm:px-6 sm:py-3">
                            Volver al blog
                        </a>
                        @if ($blogPost->isNew())
                            <span class="inline-flex items-center justify-center rounded-full border border-white/20 bg-white/5 px-5 py-2.5 text-sm font-semibold text-white sm:px-6 sm:py-3">
                                Nuevo!
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <div class="px-4 sm:px-6 lg:px-8">
            @php($hasAttachments = ! empty($attachments))

            <div @class(['mt-6 grid gap-6 lg:mt-8 lg:gap-8', 'lg:grid-cols-[minmax(0,1fr)_18rem] lg:items-start' => $hasAttachments])>
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
                        <div class="rounded-[2rem] border border-slate-200 bg-slate-50 px-4 py-5 shadow-sm sm:px-6 sm:py-6 lg:px-8">
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
                                        class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white p-3 text-left shadow-sm transition md:hover:border-slate-300 md:hover:bg-slate-50 sm:gap-4 sm:p-4"
                                    >
                                        <span class="min-w-0 flex-1">
                                            <span class="block truncate text-sm font-semibold text-slate-950">
                                                {{ $attachment['name'] }}
                                            </span>
                                            <span class="mt-1 block text-xs uppercase tracking-[0.22em] text-slate-500">
                                                {{ strtoupper($attachment['extension']) }}
                                            </span>
                                        </span>

                                        <span class="shrink-0 self-center text-sm font-semibold text-brand-700">
                                            Abrir
                                        </span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </aside>
                @endif
            </div>
        </div>
    </article>
@endsection
