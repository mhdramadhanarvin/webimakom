@section('title', $article->title . ' | Ikatan Mahasiswa Komputer Universitas Pembangunan Panca Budi')
<x-new-app-layout>
    <div class="fullscreen full-image max-h-[7em]">
        <div class="overlay content-center first-content tertienary">
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-6">
        <div class="col-span-4 px-5 lg:px-20 py-10">
            <main class="lg:pt-16 lg:pb-24 antialiased">
                <div class="px-4 max-w-screen-xl ">
                    <article
                        class="w-full max-w-5xl format format-sm sm:format-base lg:format-lg format-blue dark:format-invert">
                        <header class="mb-4 lg:mb-6 not-format">
                            <address class="flex items-center mb-6 not-italic">
                                <div class="inline-flex items-center mr-3 text-sm text-gray-900 dark:text-white">
                                    <img class="mr-4 w-16 h-16 rounded-full"
                                        src="{{ $article->user->photo == null ? url('./images/default.webp') : asset('storage/' . $article->user->photo) }}"
                                        alt="{{ $article->user->name }}">
                                    <div>
                                        <a href="javascript:void(0);" rel="author"
                                            class="text-xl font-bold text-gray-900 dark:text-white" aria-label="Penulis artikel {{ $article->user->name }}">{{ $article->user->name }}</a>
                                        <p class="text-base text-gray-500 dark:text-gray-400">
                                            {{ $article->user->roles()->first()->name }}</p>
                                        <p class="text-base text-gray-500 dark:text-gray-400">
                                            <time>{{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}</time>
                                        </p>
                                    </div>
                                </div>
                            </address>
                            <h1
                                class="mb-0 text-3xl font-extrabold leading-tight text-gray-900 lg:mb-3 lg:text-4xl dark:text-white">
                                {{ $article->title }}
                                @if ($article->status === 0)
                                    <span
                                        class="inline-block align-middle rounded-md bg-zinc-400 px-2 py-1 text-lg font-medium text-white ring-1 ring-inset ring-blue-700/10">
                                        DRAFT
                                    </span>
                                @endif
                            </h1>
                            <a href="javascript:void(0);"
                                class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10" aria-label="Kategori artikel {{ $article->article_category->name }}">{{ $article->article_category->name }}</a>
                        </header>
                        <div>
                            <img class="rounded-2xl object-cover max-h-96 mb-5 bg-cover" src="{{ asset('storage/' . $article->thumbnail) }}" />
                        </div>
                        <div>{!! $article->content !!}</div>
                        <div class="row mt-10">
                            <span class="align-text-bottom mr-2"> KATA KUNCI : </span>
                            @foreach ($article->keyword as $keyword)
                                <a href="javascript:void(0);"
                                    class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10 m-1">{{ $keyword }}</a>
                            @endforeach
                        </div>
                        <div class="pt-5 justify-center">
                            <hr class="h-px my-8 bg-zinc-400 border-0 dark:bg-gray-700">
                            <a href="{{ $l->facebook ?? 'javascript:void(0);' }}" aria-label="Share link facebook">
                                <i class="text-3xl mr-5 fa-brands fa-facebook hover:text-blue-700"
                                    aria-hidden="true"></i>
                            </a>
                            <a href="{{ $l->instagram ?? 'javascript:void(0);' }}" aria-label="Share link instagram">
                                <i class="text-3xl mr-5 fa-brands fa-twitter hover:text-blue-700"
                                    aria-hidden="true"></i>
                            </a>
                            <a href="{{ $l->linkedin ?? 'javascript:void(0);' }}" aria-label="Share link linkedin">
                                <i class="text-2xl mr-5 fa-solid fa-link hover:text-blue-700" aria-hidden="true"></i>
                            </a>
                            <span class="justify-start">{{ $article->visit_count_total }}x dilihat</span>
                            <hr class="h-px my-8 bg-zinc-400 border-0 dark:bg-gray-700">
                        </div>
                    </article>
                </div>
            </main>
        </div>
        <div class="col-span-2 py-16">
            <div class="block w-screen px-2 mb-3">
                <h2 class="text-2xl text-center lg:text-left font-extrabold"> Artikel Terkait </h2>
            </div>
            @foreach ($related_article as $related)
                <article
                    class="flex max-w-md flex-col rounded-2xl px-8 lg:px-4 my-5 lg:my-0 md:max-w-5xl md:flex-row md:items-center">
                    <div class="shrink-0 my-4 md:mr-8 md:max-w-sm">
                        <a href="{{ route('article.detail', ['slug' => $related->slug]) }}" aria-label="Thumbnail related artikel {{ $related->title }}">
                            <img class="rounded-2xl object-cover h-48 lg:h-32 w-screen lg:w-32"
                                src="{{ asset('storage/' . $related->thumbnail) }}" alt="Thumbnail related article {{ $related->title }}" />
                        </a>
                    </div>
                    <div class="">
                        <div class="mb-px text-slate-600">
                            <span
                                class="">{{ \Carbon\Carbon::parse($related->created_at)->format('d M Y') }}</span>
                        </div>
                        <a href="{{ route('article.detail', ['slug' => $related->slug]) }}"
                            class="mb-1 block text-lg font-medium text-gray-700" aria-label="Related artikel {{ $related->title }}">
                            {{ $related->title }}
                        </a>
                        <div class="">
                            <p class="w-56">
                                <strong class="block font-medium text-gray-700">{{ $related->user->name }}</strong>
                            </p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-new-app-layout>
