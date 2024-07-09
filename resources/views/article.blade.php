@section('title', 'Artikel | Ikatan Mahasiswa Komputer Universitas Pembangunan Panca Budi')
<x-new-app-layout>
    <div class="fullscreen full-image max-h-[7em]">
        <div class="overlay content-center first-content tertienary">
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <div class="col-span-4 pr-0 pl-0 lg:pl-20 lg:pr-0 py-10">
            <div class="block w-screen p-5">
                <h1 class="text-2xl text-center lg:text-left font-extrabold"> Artikel Terbaru </h1>
            </div>
            @foreach ($all_article as $all)
                <article
                    class="flex max-w-md flex-col rounded-2xl px-8 lg:px-4 my-5 lg:md-1 md:max-w-5xl md:flex-row md:items-center">
                    <div class="shrink-0 my-4 md:mr-8 md:max-w-sm">
                        <a href="{{ route('article.detail', ['slug' => $all->slug]) }}" aria-label="Thumbnail Artikel link ke {{ $all->title }}">
                            <img class="rounded-2xl object-cover h-60 w-full lg:w-60"
                                src="{{ asset('storage/' . $all->thumbnail) }}" alt="Thumbnail {{ $all->title }}" />
                        </a>
                    </div>
                    <div class="py-4 sm:py-8">
                        <div class="mb-4 text-slate-600">
                            <span
                                class="">{{ \Carbon\Carbon::parse($all->created_at)->format('d M Y H:i') }}</span>
                            <a href="javascript:void(0);"
                                class="inline-flex items-center ml-5 py-1 px-3 rounded-full text-md font-medium text-gray-800 bg-slate-200 dark:bg-white/10 dark:text-white" aria-label="Kategori link ke {{ $all->article_category->name }}">
                                {{ $all->article_category->name }}
                            </a>
                        </div>
                        <a href="{{ route('article.detail', ['slug' => $all->slug]) }}"
                            class="block text-2xl font-medium text-gray-700 mb-2" aria-label="Artikel terbaru link {{ $all->title }}">
                            {{ $all->title }}
                        </a>
                        <p class="mb-5 text-gray-500">{!! Illuminate\Support\Str::words($all->content, 25, '...') !!}</p>
                        <div class="flex items-center">
                            <img class="h-10 w-10 rounded-full object-cover"
                                src="{{ $all->user->photo == null ? url('./images/default.webp') : asset('storage/' . $all->user->photo) }}"
                                alt="Photo profile author {{ $all->title }}" />
                            <p class="ml-4 w-56">
                                <strong class="block font-medium text-gray-700">{{ $all->user->name }}</strong>
                                <span class="text-sm text-gray-400">Penulis</span>
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
            <div class="flex justify-end mb-10 pb-10">
                {{ $all_article->links('custom.pagination-article') }}
            </div>
            @if ($all_article->count() == 0)
                <div class="p-5">
                    BELUM ADA DATA
                </div>
            @endif
        </div>
        <div class="col-span-2 mb-10">
            <div class="block w-screen pl-0 lg:pl-5 lg:pt-16 lg:pb-5">
                <h2 class="text-2xl text-center lg:text-left font-extrabold"> Artikel Populer </h2>
            </div>
            @foreach ($article_popular as $popular)
                <article
                    class="flex max-w-md flex-col rounded-2xl px-8 lg:px-4 my-5 lg:my-0 md:max-w-5xl md:flex-row md:items-center">
                    <div class="shrink-0 my-4 md:mr-8 md:max-w-sm">
                        <a href="{{ route('article.detail', ['slug' => $popular->slug]) }}" aria-label="Thumbnail artikel popular {{ $popular->title }}">
                            <img class="rounded-2xl object-cover h-48 lg:h-32 w-screen lg:w-32"
                                src="{{ asset('storage/' . $popular->thumbnail) }}" alt="Thumbnail popular article {{ $popular->title }}" />
                        </a>
                    </div>
                    <div class="">
                        <div class="mb-px text-slate-600">
                            <span
                                class="">{{ \Carbon\Carbon::parse($popular->created_at)->format('d M Y') }}</span>
                        </div>
                        <a href="{{ route('article.detail', ['slug' => $popular->slug]) }}"
                            class="mb-1 block text-lg font-medium text-gray-700" aria-label="Artikel popular {{ $popular->title }}">
                            {{ Illuminate\Support\Str::words($popular->title, 7, '...') }}
                        </a>
                        <div class="pt-2">
                            <p class="w-56">
                                <strong class="block font-medium text-gray-700">{{ $popular->user->name }}</strong>
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-new-app-layout>
