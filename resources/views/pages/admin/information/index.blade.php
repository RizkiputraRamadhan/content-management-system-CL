@extends('layouts.admin.app')
@section('title', $page)
@push('styles')
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Manajemen {{ $page }}</h3>
                </div>
                <div class="panel-body">
                    @can('create information')
                        <div class="panel-action">
                            <a href="{{ route('information.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Tambah Data
                            </a>
                        </div>
                    @endcan

                    @can('view information')
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <form method="GET" action="{{ route('information.index') }}">
                                    <div class="form-group">
                                        <label for="type_filter">Filter Tipe:</label>
                                        <select name="type" id="type_filter" class="form-control"
                                            onchange="this.form.submit()">
                                            <option value="">Semua</option>
                                            <option value="banner" {{ request('type') == 'banner' ? 'selected' : '' }}>Banner
                                            </option>
                                            <option value="text" {{ request('type') == 'text' ? 'selected' : '' }}>Text
                                            </option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Slug</th>
                                    <th>Gambar</th>
                                    <th>Tipe</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Dibuat Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($information as $post)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td><a href="/{{ $post->type == 'banner' ? 'banner' : 'info' }}/{{ $post->slug }}"
                                                target="_blank" rel="noopener noreferrer"><i class="fa fa-external-link"></i>
                                                Lihat</a></td>
                                        <td>
                                            @if ($post->image)
                                                <img src="{{ asset('storage/banners/' . $post->image) }}"
                                                    alt="{{ $post->title }}" width="50">
                                            @else
                                                <span>Tidak ada gambar</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->type }}</td>
                                        <td>{{ $post->createdBy ? $post->createdBy->name : 'Tidak diketahui' }}</td>
                                        <td>{{ $post->created_at->format('d M Y H:i') }}</td>
                                        <td>
                                            @can('edit information')
                                                <a href="{{ route('information.edit', $post->id) }}"
                                                    class="btn btn-primary btn-xs">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            @endcan
                                            @can('delete information')
                                                <form action="{{ route('information.destroy', $post->id) }}" method="POST"
                                                    style="display: inline;" onsubmit="return confirmDelete(this)">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-xs">
                                                        <i class="fa fa-trash"></i> Hapus
                                                    </button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-danger">Anda tidak memiliki izin untuk melihat daftar informasi.</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
@endpush
@push('scripts')
    <script></script>
@endpush
