@foreach ($posts as $post)
    <article class="group overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition md:hover:-translate-y-1 md:hover:shadow-[0_12px_24px_rgba(15,23,42,0.08)]">
        <a href="{{ route('blog.show', $post) }}" class="block">
            <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->title }}" class="size-full object-cover transition duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(15,23,42,0)_50%,rgba(15,23,42,0.55)_100%)]"></div>
                @if ($post->isNew())
                    <span class="absolute left-3 top-3 rounded-full bg-amber-400 px-2.5 py-1 text-[0.7rem] font-semibold uppercase tracking-[0.2em] text-slate-950 sm:left-4 sm:top-4 sm:px-3 sm:py-1.5 sm:text-xs">
                        Nuevo!
                    </span>
                @endif
            </div>

            <div class="p-5 sm:p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                    {{ $post->published_at?->format('d/m/Y') }}
                </p>
                <h3 class="mt-2 text-xl font-semibold tracking-tight text-slate-950 sm:mt-3 sm:text-2xl">
                    {{ $post->title }}
                </h3>
                <p class="mt-2 text-sm leading-6 text-slate-600 sm:mt-3 sm:text-base sm:leading-7">
                    {{ $post->excerpt(150) }}
                </p>
                <span class="mt-4 inline-flex items-center text-sm font-semibold text-brand-700 sm:mt-5">
                    Leer más
                </span>
            </div>
        </a>
    </article>
@endforeach
