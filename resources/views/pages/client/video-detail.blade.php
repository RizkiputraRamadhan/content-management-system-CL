@extends('layouts.client.app')

@section('content')
    <div class="relative isolate bg-white px-4 py-6 lg:px-8 lg:py-10">
        <!-- Elemen Loading -->
        <div id="loading" class="fixed inset-0 bg-gray-100 bg-opacity-75 flex items-center justify-center z-50">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
        </div>

        <!-- SVG Latar Belakang -->
        <div class="absolute inset-0 -z-10 overflow-hidden">
            <svg class="absolute top-0 left-[max(50%,25rem)] h-[64rem] w-[128rem] -translate-x-1/2 stroke-gray-200 [mask-image:radial-gradient(64rem_64rem_at_top,white,transparent)]"
                aria-hidden="true">
                <defs>
                    <pattern id="e813992c-7d03-4cc4-a2bd-151760b470a0" width="200" height="200" x="50%" y="-1"
                        patternUnits="userSpaceOnUse">
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <svg x="50%" y="-1" class="overflow-visible fill-gray-50">
                    <path
                        d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M-300.5 600h201v201h-201Z"
                        stroke-width="0" />
                </svg>
                <rect width="100%" height="100%" stroke-width="0" fill="url(#e813992c-7d03-4cc4-a2bd-151760b470a0)" />
            </svg>
        </div>

        <!-- Kontainer Utama -->
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row gap-6">
            <!-- Bagian Kiri: Video Utama -->
            <div class="w-full lg:w-2/3">
                <!-- Iframe Video -->
                <div class="w-full aspect-video">
                    <iframe id="youtubeVideo" class="w-full h-full rounded-sm"
                        src="{{ 'https://www.youtube.com/embed/' . Str::after($video->link_yt, 'v=') . '?autoplay=1&mute=0' }}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                </div>

                <!-- Informasi Video -->
                <div class="mt-4">
                    <h1 class="text-2xl font-bold text-gray-900">
                        {{ $video->title }}
                    </h1>
                    <div class="flex items-center justify-between mt-2 text-gray-600 text-sm">
                        <div class="flex items-center gap-2">
                            <img src="{{ $video->createdBy->image ? asset('storage/' . $video->createdBy->image) : asset('dist/images/users/avatar-1.jpg') }}"
                                alt="" class="w-8 h-8 rounded-full">
                            <a class="hover:text-blue-600">{{ $video->createdBy->name }}</a>
                        </div>
                        <p>
                            {{ \Carbon\Carbon::parse($video->created_at)->locale('id')->translatedFormat('l, d M Y') }}
                        </p>
                    </div>
                    <div class="mt-4 text-gray-700">
                        {!! $content !!}
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan: Video Terkait -->
            <div class="w-full lg:w-1/3">
                @include('widget.client.header-title', ['title' => 'Video Lainnya', 'link' => '/videos'])
                <div class="space-y-2">
                    <div class="grid grid-cols-12 lg:gap-2">
                        @foreach ($videos as $item)
                            <div class="col-span-12 ">
                                <div class="mx-auto {{ $item->id == $video->id ? 'border border-dashed border-green-400' : ''}} w-full rounded-lg shadow-sm  p-2 mb-2">
                                    <div class="flex space-x-3">
                                        <a href="{{ route('video_detail', $item->slug) }}"
                                            class="lg:w-40  w-30 object-cover rounded-lg overflow-hidden">
                                            <img src="{{ asset('storage/videos/' . $item->image) }}"
                                                alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        </a>
                                        <div class="flex-1">
                                            <a class="text-gray-700 font-semibold lg:text-lg text-xs hover:text-gray-600 transition-colors duration-200"
                                                href="{{ route('video_detail', $item->slug) }}">
                                                {{ $item->title }}
                                            </a>
                                            <div class="mt-2">
                                                <div class="grid grid-cols-3 gap-4">
                                                    <div class="col-span-2 h-2"></div>
                                                    <div class="col-span-1 h-2"></div>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center space-x-2">
                                                        <img src="{{ $item->createdBy->image ? asset('storage/' . $item->createdBy->image) : asset('dist/images/users/avatar-1.jpg') }}"
                                                            alt="Author" class="w-5 h-5 lg:w-7 lg:h-7 rounded-full">
                                                        <div>
                                                            <a
                                                                class="text-gray-700 hover:text-blue-600 text-xs font-semibold">
                                                                {{ $item->createdBy->name }}
                                                            </a>
                                                            <p class="text-gray-500 text-xs">
                                                                <time
                                                                    datetime="{{ \Carbon\Carbon::parse($item->published_at)->toDateTimeString() }}"
                                                                    class="text-gray-500">
                                                                    {{ \Carbon\Carbon::parse($item->published_at)->locale('id')->translatedFormat('l, d M Y') }}
                                                                </time>
                                                            </p>
                                                        </div>
                                                    </div>
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
        </div>
    </div>
@endsection

@push('styles')
    <style>
        #loading {
            display: flex; 
        }
        .animate-spin {
            border: 4px solid #f3f3f3; 
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 64px;
            height: 64px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loading = document.getElementById('loading');
            const iframe = document.getElementById('youtubeVideo');

            iframe.onload = function () {
                loading.style.display = 'none';
            };

            setTimeout(() => {
                if (loading.style.display !== 'none') {
                    loading.style.display = 'none';
                }
            }, 5000); 
        });
    </script>
@endpush