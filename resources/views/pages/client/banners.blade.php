@extends('layouts.client.app')

@section('header')
    @include('widget.client.header-section', [
        'segment' => 'Halaman',
        'data' => 'Banner',
    ])
@endsection

@section('content')
    <div class="space-y-2">
        <div class="grid grid-cols-12 lg:gap-4 py-2">
            @forelse ($banners as $item)
                <div class="col-span-12 lg:col-span-6">
                    <div class="mx-auto w-full rounded mb-2 relative group">
                        <div class="flex space-x-4">
                            <div class="w-full h-30 lg:h-50 rounded bg-gray-200 relative overflow-hidden">
                                <img src="{{ asset('storage/banners/' . $item->image) }}" alt="{{ $item->title }}"
                                    class="w-full h-full object-cover rounded transition-opacity duration-300 group-hover:opacity-80">
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300">
                                    <a href="/banner/{{ $item->slug }}" title="detail banner"
                                        class="text-white bg-gray-700 p-1 rounded-full mr-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-12">
                    @include('widget.client.no-data-search')
                </div>
            @endforelse
        </div>
    </div>
    <hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded-sm md:my-10 ">
    @include('widget.client.paginate', ['data' => $banners])
@endsection