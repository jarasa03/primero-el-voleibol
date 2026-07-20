@foreach ($posts as $post)
    <article class="group overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm transition md:hover:-translate-y-1 md:hover:shadow-[0_12px_24px_rgba(15,23,42,0.08)]">
        <a href="{{ route('blog.show', $post) }}" class="block">
            <div class="relative aspect-[4/3] overflow-hidden bg-slate-200">
                <img src="{{ $post->featuredImageUrl() }}" alt="{{ $post->title }}" class="size-full object-cover transition duration-700 group-hover:scale-105">
                <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(15,23,42,0)_50%,rgba(15,23,42,0.55)_100%)]"></div>
                @if ($post->isNew())
                    <span class="absolute left-4 top-4 rounded-full bg-amber-400 px-3 py-1.5 text-xs font-semibold uppercase tracking-[0.2em] text-slate-950">
                        Nuevo!
                    </span>
                @endif
            </div>

            <div class="p-6">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-slate-500">
                    {{ $post->published_at?->format('d/m/Y') }}
                </p>
                <h3 class="mt-3 text-2xl font-semibold tracking-tight text-slate-950">
                    {{ $post->title }}
                </h3>
                <p class="mt-3 text-base leading-7 text-slate-600">
                    {{ $post->excerpt(150) }}
                </p>
                <span class="mt-5 inline-flex items-center text-sm font-semibold text-brand-700">
                    Leer más
                </span>
            </div>
        </a>
    </article>
@endforeach
