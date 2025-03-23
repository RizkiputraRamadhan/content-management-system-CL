@extends('layouts.client.app')

@section('content')
    <div class="relative isolate -mt-8 overflow-hidden bg-white px-2 py-10 lg:py-20 lg:overflow-visible lg:px-0">
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <svg class="absolute top-0 left-[max(50%,25rem)] h-[64rem] w-[128rem] -translate-x-1/2 stroke-gray-200 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]" aria-hidden="true">
                <defs>
                    <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
                    <path d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z" stroke-width="0" />
                </svg>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
            </svg>
        </div>
        <div class="mx-auto grid max-w-2xl grid-cols-1 gap-x-8 gap-y-16 lg:mx-0 lg:max-w-none lg:grid-cols-2 lg:items-start lg:gap-y-10">
            <div class="lg:col-span-2 lg:col-start-1 lg:row-start-1 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8">
                <div class="lg:pr-4">
                    <div class="lg:max-w-lg">
                        <a href="/{{ $post->category->slug }}" class="text-base/7 font-semibold text-blue-600">
                            {{ $post->category->name }}
                        </a>
                        <h1 class="mt-2 text-xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-3xl">
                            {{ $post->title }}
                        </h1>
                        <div class="space-y-10 my-3">
                            <article class="space-y-8">
                                <div class="space-y-6">
                                    <div class="flex flex-col items-start justify-between w-full md:flex-row md:items-center text-gray-600">
                                        <div class="flex items-center space-x-2">
                                            <img src="{{ $post->createdBy->image ? getFile($post->createdBy->image) : asset('dist/images/users/avatar-1.jpg') }}"
                                                alt="" class="w-8 h-8 rounded-full">
                                            <a href="/author/{{ $post->createdBy->slug }}"
                                                class="text-sm font-semibold ">{{ $post->createdBy->name }}</a>
                                        </div>
                                        <p class="flex-shrink-0 mt-3 text-sm md:mt-0">
                                            {{ \Carbon\Carbon::parse($post->published_at)->locale('id')->translatedFormat('l, d M Y') }} • {{ $post->counter }} views
                                        </p>
                                    </div>
                                </div>
                            </article>
                            <div>
                                <div class="flex flex-wrap py-3 gap-2 border-t border-dashed border-gray-400 dark:border-gray-600">
                                    @foreach (json_decode($post->tags) as $tag)
                                        @php $tags = App\Models\PostTags::tagById($tag) @endphp
                                        <a rel="noopener noreferrer" href="/tag/{{ $tags->slug }}"
                                            class="px-3 py-1 rounded-sm hover:underline bg-blue-400 dark:bg-blue-600 text-gray-900 dark:text-gray-50">
                                            #{{ $tags->name }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:-mt-1 -mt-15 lg:-ml-12 lg:p-3 lg:top-4 lg:col-start-2 lg:row-span-2 lg:row-start-1 lg:overflow-hidden image-container">
                <img class="w-full rounded-sm bg-gray-900 ring-1 shadow-lg ring-gray-400/10 sm:w-[57rem] post-image"
                    src="{{ getFile($post->image) }}" alt="">
            </div>

            <div class="lg:col-span-2 -mt-10 lg:col-start-1 lg:row-start-2 lg:mx-auto lg:grid lg:w-full lg:max-w-7xl lg:grid-cols-2 lg:gap-x-8 lg:px-8 post-content">
                <div class="lg:pr-4">
                    <div class="max-w-xl text-base/7 text-gray-700 lg:max-w-lg">
                        {!! $content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

      <!-- Relate Berita -->
    <div class="col-span-12 lg:p-3">
        @include('widget.client.header-title', ['title' => 'Relate Artikel', 'link' => ''])
        <div class="space-y-2">
            <div class="grid grid-cols-12 lg:gap-2">
                @foreach ($relate as $item)
                    <div class="col-span-12 md:col-span-6">
                        <div class="mx-auto w-full rounded-lg shadow-sm lg:p-4 p-2 mb-2">
                            <div class="flex space-x-4">
                                <div class="size-30 rounded-lg overflow-hidden">
                                    <img src="{{ getFile($item->image) }}"
                                        alt="{{ $item->title }}"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1 space-y-5">
                                    <span class="text-blue-600 font-semibold lg:hidden">
                                        <a href="/{{ $item->category->slug }}"
                                        class="relative z-10 inline-flex items-center p-1 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition-colors duration-200 group">
                                            <span class="flex items-center justify-center w-3 h-3 mr-2 text-white bg-blue-600 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-hash">
                                                    <line x1="4" x2="20" y1="9" y2="9" />
                                                    <line x1="4" x2="20" y1="15" y2="15" />
                                                    <line x1="10" x2="8" y1="3" y2="21" />
                                                    <line x1="16" x2="14" y1="3" y2="21" />
                                                </svg>
                                            </span>
                                            <span class="mr-2">{{ $item->category->name }}</span>
                                            <svg class="w-3 h-3 ml-auto text-gray-400 group-hover:text-gray-600"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </span>
                                    <br class="lg:hidden">
                                    <a class="text-gray-700 font-semibold lg:text-lg text-xs hover:text-gray-600 transition-colors duration-200"
                                    href="/{{ $item->category->slug }}/{{ $item->slug }}">
                                        {{ $item->title }}
                                    </a>
                                    <div class="lg:space-y-5">
                                        <div class="grid grid-cols-3 gap-4">
                                            <div class="col-span-2 h-2"></div>
                                            <div class="col-span-1 h-2"></div>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <img src="{{ $item->createdBy->image ? getFile($item->createdBy->image) : asset('dist/images/users/avatar-1.jpg') }}"
                                                    alt="Author"
                                                    class="w-5 h-5 lg:w-10 lg:h-10 rounded-full">
                                                <div>
                                                    <a href="/author/{{ $item->createdBy->slug }}"
                                                    class="text-gray-700 hover:text-blue-600 text-xs font-semibold">
                                                        {{ $item->createdBy->name }}
                                                    </a>
                                                    <p class="text-gray-500 text-xs lg:text-sm">
                                                        <time datetime="{{ \Carbon\Carbon::parse($item->published_at)->toDateTimeString() }}"
                                                            class="text-gray-500">
                                                            {{ \Carbon\Carbon::parse($item->published_at)->locale('id')->translatedFormat('l, d M Y') }}
                                                        </time>
                                                    </p>
                                                </div>
                                            </div>
                                            <span class="text-blue-600 font-semibold hidden lg:block">
                                                <a href="/{{ $item->category->slug }}"
                                                class="relative z-10 inline-flex items-center p-1 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition-colors duration-200 group">
                                                    <span class="flex items-center justify-center w-3 h-3 mr-2 text-white bg-blue-600 rounded-full">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10"
                                                            height="10" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"
                                                            class="lucide lucide-hash">
                                                            <line x1="4" x2="20" y1="9" y2="9" />
                                                            <line x1="4" x2="20" y1="15" y2="15" />
                                                            <line x1="10" x2="8" y1="3" y2="21" />
                                                            <line x1="16" x2="14" y1="3" y2="21" />
                                                        </svg>
                                                    </span>
                                                    <span class="mr-2">{{ $item->category->name }}</span>
                                                    <svg class="w-3 h-3 ml-auto text-gray-400 group-hover:text-gray-600"
                                                        fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Terpopuler -->
    @include('widget.client.most-popular', ['data' => $mostPopular])
    <!-- Banner -->
    @include('widget.client.banner', ['data' => $banner_1])
@endsection

@push('styles')
<style>
    @media (min-width: 1024px) {
        .image-container {
            position: sticky;
            top: 1rem;
            transition: all 0.3s ease;
        }

        .post-image {
            max-height: calc(100vh - 2rem);
            object-fit: cover;
        }

        body:has(.most-popular:target) .image-container {
            position: relative;
            top: 0;
        }
    }
</style>
@endpush