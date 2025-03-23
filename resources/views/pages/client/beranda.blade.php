@extends('layouts.client.app')
@push('styles')
    <style>
        .carousel-slide {
            transition: opacity 0.7s ease-in-out;
        }

        .carousel-slide.active {
            display: block;
            opacity: 1;
        }

        .carousel-slide {
            display: none;
            opacity: 0;
        }
    </style>
@endpush
@section('content')
    <div class="grid grid-cols-12 gap-2">
        <!-- Slide News Column -->
        <div class="col-span-12 md:col-span-8 lg:h-screen">
            <div class="space-y-2">
                <div id="controls-carousel" class="relative w-full" data-carousel="static">
                    @foreach ($slide as $item)
                        <section class="carousel-slide duration-700 ease-in-out hidden" data-carousel-news>
                            <!-- Carousel wrapper -->
                            <div class="relative h-40 overflow-hidden rounded-lg md:h-96">
                                <img src="{{ getFile($item->image) }}"
                                    class="block w-full h-full object-cover" alt="slide-image">
                            </div>
                            <div class="relative">
                                <article class="flex mt-2 flex-col items-start justify-between">
                                    <div class="flex items-center gap-x-4 text-xs">
                                        <time
                                            datetime="{{ \Carbon\Carbon::parse($item->published_at)->toDateTimeString() }}"
                                            class="text-gray-500">
                                            {{ \Carbon\Carbon::parse($item->published_at)->locale('id')->translatedFormat('l, d M Y') }}
                                        </time>
                                        <a href="{{ $item->category->slug }}"
                                            class="relative z-10 inline-flex items-center lg:px-3 px-1 py-1 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition-colors duration-200 group">
                                            <span
                                                class="flex items-center justify-center w-5 h-5 mr-2 text-white bg-blue-600 rounded-full">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
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
                                            <svg class="w-4 h-4 ml-auto text-gray-400 group-hover:text-gray-600"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="group relative">
                                        <h3
                                            class="text-sm lg:text-lg/6 font-semibold text-gray-900 group-hover:text-gray-600">
                                            <a href="/{{ $item->category->slug }}/{{ $item->slug }}">
                                                <span class="absolute inset-0"></span>
                                                {{ $item->title }}
                                            </a>
                                        </h3>
                                    </div>
                                </article>
                                <!-- Slider controls -->
                                <div class="absolute bottom-0 right-0 flex space-x-2 lg:mb-4 mb-5 mr-2 z-30">
                                    <button type="button"
                                        class="flex items-center justify-center lg:px-1 cursor-pointer group focus:outline-none"
                                        data-carousel-news-prev>
                                        <span
                                            class="inline-flex items-center justify-center lg:w-10 lg:h-10 w-8 h-8 rounded-full bg-slate-100  group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                            <svg class="lg:w-4 lg:h-4 w-2 h-2 text-gray-800 rtl:rotate-180"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="M5 1 1 5l4 4" />
                                            </svg>
                                            <span class="sr-only">Previous</span>
                                        </span>
                                    </button>
                                    <button type="button"
                                        class="flex items-center justify-center lg:px-1 cursor-pointer group focus:outline-none"
                                        data-carousel-news-next>
                                        <span
                                            class="inline-flex items-center justify-center lg:w-10 lg:h-10 w-8 h-8 rounded-full bg-slate-100  group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                                            <svg class="lg:w-4 lg:h-4 w-2 h-2 text-gray-800 rtl:rotate-180"
                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                viewBox="0 0 6 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                    stroke-width="2" d="m1 9 4-4-4-4" />
                                            </svg>
                                            <span class="sr-only">Next</span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="col-span-12 md:col-span-4 mt-5 lg:mt-1 rounded lg:px-4">
            @include('widget.client.header-title', [
                'title' => 'Berita Terbaru',
                'link' => 'posts?type=terbaru',
            ])
            <div class="space-y-2 overflow-y-auto custom-scrollbar-y h-[calc(100vh-8rem)] max-h-[800px]">
                @forelse ($latestNews as $item)
                    <div class="mx-auto w-full rounded-md p-2 mb-2">
                        <div class="flex space-x-4">
                            <div class="size-20 rounded overflow-hidden">
                                <img src="{{ getFile($item->image) }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 flex flex-col justify-between">
                                <div class="rounded">
                                    <a class="text-gray-700 font-semibold hover:text-gray-600 transition-colors duration-200"
                                        href="/{{ $item->category->slug }}/{{ $item->slug }}">
                                        {{ $item->title }}
                                    </a>
                                </div>
                                <div class="flex items-center justify-between gap-x-4 text-xs mt-auto">
                                    <time datetime="{{ \Carbon\Carbon::parse($item->published_at)->toDateTimeString() }}"
                                        class="text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->published_at)->locale('id')->translatedFormat('l, d M Y') }}
                                    </time>
                                    <a href="{{ $item->category->slug }}"
                                        class="relative z-10 inline-flex items-center p-1 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition-colors duration-200 group">
                                        <span
                                            class="flex items-center justify-center w-3 h-3 mr-2 text-white bg-blue-600 rounded-full">
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
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    @for ($i = 0; $i < 5; $i++)
                        @include('widget.client.load-data-1')
                    @endfor
                @endforelse
            </div>
        </div>

        <!-- Terpopuler -->
        @include('widget.client.most-popular', ['data' => $mostPopular])

        <!-- Banner -->
        @include('widget.client.banner', ['data' => $banner_1])

        <!-- Rekomendasi Berita -->
        <div class="col-span-12 lg:p-3">
            @include('widget.client.header-title', ['title' => 'Rekomendasi Berita', 'link' => ''])
            <div class="space-y-2">
                <div class="grid grid-cols-12 lg:gap-2">
                    @foreach ($recommended as $item)
                        <div class="col-span-12 md:col-span-6">
                            <div class="mx-auto w-full rounded-lg shadow-sm lg:p-4 p-2 mb-2">
                                <div class="flex space-x-4">
                                    <div class="size-30 rounded-lg overflow-hidden">
                                        <img src="{{ getFile($item->image) }}"
                                            alt="{{ $item->title }}" class="w-full h-full object-cover">
                                    </div>
                                    <div class="flex-1 space-y-6">
                                        <span class="text-blue-600 font-semibold lg:hidden">
                                            <a href="{{ $item->category->slug }}"
                                                class="relative z-10 inline-flex items-center p-1 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition-colors duration-200 group">
                                                <span
                                                    class="flex items-center justify-center w-3 h-3 mr-2 text-white bg-blue-600 rounded-full">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="lucide lucide-hash">
                                                        <line x1="4" x2="20" y1="9"
                                                            y2="9" />
                                                        <line x1="4" x2="20" y1="15"
                                                            y2="15" />
                                                        <line x1="10" x2="8" y1="3"
                                                            y2="21" />
                                                        <line x1="16" x2="14" y1="3"
                                                            y2="21" />
                                                    </svg>
                                                </span>
                                                <span class="mr-2">{{ $item->category->name }}</span>
                                                <svg class="w-3 h-3 ml-auto text-gray-400 group-hover:text-gray-600"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 5l7 7-7 7" />
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
                                                        alt="Author" class="w-5 h-5 lg:w-10 lg:h-10 rounded-full">
                                                    <div>
                                                        <a href="/author/{{ $item->createdBy->slug }}"
                                                            class="text-gray-700 hover:text-blue-600 text-xs font-semibold">
                                                            {{ $item->createdBy->name }}
                                                        </a>
                                                        <p class="text-gray-500 text-xs lg:text-sm">
                                                            <time
                                                                datetime="{{ \Carbon\Carbon::parse($item->published_at)->toDateTimeString() }}"
                                                                class="text-gray-500">
                                                                {{ \Carbon\Carbon::parse($item->published_at)->locale('id')->translatedFormat('l, d M Y') }}
                                                            </time>
                                                        </p>
                                                    </div>
                                                </div>
                                                <span class="text-blue-600 font-semibold hidden lg:block">
                                                    <a href="{{ $item->category->slug }}"
                                                        class="relative z-10 inline-flex items-center p-1 text-xs font-medium text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition-colors duration-200 group">
                                                        <span
                                                            class="flex items-center justify-center w-3 h-3 mr-2 text-white bg-blue-600 rounded-full">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="10"
                                                                height="10" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="lucide lucide-hash">
                                                                <line x1="4" x2="20" y1="9"
                                                                    y2="9" />
                                                                <line x1="4" x2="20" y1="15"
                                                                    y2="15" />
                                                                <line x1="10" x2="8" y1="3"
                                                                    y2="21" />
                                                                <line x1="16" x2="14" y1="3"
                                                                    y2="21" />
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

        <!-- Video reels -->
        @include('widget.client.video', ['data' => $videos])

        <!-- Photos Column -->
        @include('widget.client.photos', ['data' => $photos])

        <!-- Informasi Column -->
        <div class="col-span-12 md:col-span-4 p-4 bg-slate-100 rounded">
            @include('widget.client.header-title', ['title' => 'Informasi', 'link' => 'info'])
            <div class="space-y-2 overflow-y-auto custom-scrollbar-y  max-h-[800px]">
                @forelse ($information as $item)
                    <div class="mx-auto w-full border-b border-dashed border-gray-300 p-2 mb-2">
                        <div class="flex space-x-4">
                            <div class="rounded overflow-hidden">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="lucide lucide-info text-blue-400">
                                    <circle cx="12" cy="12" r="10" />
                                    <path d="M12 16v-4" />
                                    <path d="M12 8h.01" />
                                </svg>
                            </div>
                            <div class="flex-1 flex flex-col justify-between">
                                <div class="rounded">
                                    <a class="text-gray-700 font-semibold hover:text-gray-600 transition-colors duration-200"
                                        href="/info/{{ $item->slug }}">
                                        {{ $item->title }}
                                    </a>
                                </div>
                                <div class="flex items-center justify-between gap-x-4 text-xs mt-2">
                                    <time datetime="{{ \Carbon\Carbon::parse($item->published_at)->toDateTimeString() }}"
                                        class="text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->published_at)->locale('id')->translatedFormat('l, d M Y') }}
                                    </time>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    @for ($i = 0; $i < 5; $i++)
                        @include('widget.client.load-data-1')
                    @endfor
                @endforelse
            </div>
        </div>

        <!-- Banner -->
        @include('widget.client.banner', ['data' => $banner_2])

        <div class="col-span-12 rounded p-4 bg-slate-100">
            @include('widget.client.tags', ['data' => $tags])
        </div>

    </div>
@endsection
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            let currentSlide = 0;
            const slides = $('.carousel-slide');
            const totalSlides = slides.length;

            function showSlide(index) {
                slides.removeClass('active').css('opacity', '0');
                slides.eq(index).addClass('active').css('opacity', '1');
            }

            $('[data-carousel-news-prev]').on('click', function() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                showSlide(currentSlide);
            });

            $('[data-carousel-news-next]').on('click', function() {
                currentSlide = (currentSlide + 1) % totalSlides;
                showSlide(currentSlide);
            });

            showSlide(currentSlide);

            function adjustIconSize() {
                if ($(window).width() < 768) {
                    $('.w-10.h-10').removeClass('w-10 h-10').addClass('w-8 h-8');
                    $('.w-4.h-4').removeClass('w-4 h-4').addClass('w-3 h-3');
                } else {
                    $('.w-8.h-8').removeClass('w-8 h-8').addClass('w-10 h-10');
                    $('.w-3.h-3').removeClass('w-3 h-3').addClass('w-4 h-4');
                }
            }

            adjustIconSize();
            $(window).on('resize', adjustIconSize);
        });
    </script>
@endpush
