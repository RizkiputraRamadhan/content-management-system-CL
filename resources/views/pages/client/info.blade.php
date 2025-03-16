@extends('layouts.client.app')

@section('header')
    @include('widget.client.header-section', [
        'segment' => 'Halaman',
        'data' => 'Informasi',
    ])
@endsection

@section('content')
    <div class="space-y-2">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 ">
            @forelse ($info as $item)
                <div class="border-b border-dashed border-gray-300 p-2">
                    <div class="flex space-x-4 lg:text-2xl">
                        <div class="rounded overflow-hidden">
                            <img src="{{ asset('assets/img/informasi.png') }}" alt="" class="lg:w-10 w-7"
                                srcset="">
                        </div>
                        <div class="flex-1 flex flex-col justify-between ">
                            <div class="rounded">
                                <a class="text-gray-700  font-semibold hover:text-gray-600 transition-colors duration-200"
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
                <div class="col-span-2">
                    @include('widget.client.no-data-search')
                </div>
            @endforelse
        </div>
    </div>
    <hr class="w-48 h-1 mx-auto my-4 bg-gray-100 border-0 rounded-sm md:my-10 ">
    @include('widget.client.paginate', ['data' => $info])
@endsection
