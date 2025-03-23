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
                    @can('create posts')
                        <div class="panel-action">
                            <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Tambah Data
                            </a>
                        </div>
                    @endcan

                    @can('view posts')
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Link</th>
                                    <th>Judul</th>
                                    <th>Gambar</th>
                                    <th>Views</th>
                                    <th>Status</th>
                                    <th>Kategori</th>
                                    <th>Tags</th>
                                    <th>Dibuat Oleh</th>
                                    <th>Diperbarui Oleh</th>
                                    <th>Dipublikasikan Pada</th>
                                    <th>Dibuat Pada</th>
                                    <th>Diperbarui Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($posts as $post)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="/{{  $post->category->slug }}/{{ $post->slug }}" target="_blank" rel="noopener noreferrer"><i
                                            class="fa fa-external-link"></i> Lihat</a></td>
                                        <td>{{ $post->title }}</td>
                                        <td>
                                            @if ($post->image)
                                                <img src="{{ getFile($post->image) }}" alt="{{ $post->title }}" width="50">
                                            @else
                                                <span>Tidak ada gambar</span>
                                            @endif
                                        </td>
                                        <td>{{ $post->counter }}</td>
                                        <td>{{ $post->status }}</td>
                                        <td>{{ $post->category ? $post->category->name : 'Tidak ada kategori' }}</td>
                                        <td>
                                            @php
                                                $tagIds = $post->tags ? json_decode($post->tags, true) : [];
                                                $tagNames = [];
                                                if (!empty($tagIds)) {
                                                    foreach ($tagIds as $tagId) {
                                                        $tag = $tags->firstWhere('id', $tagId);
                                                        if ($tag) {
                                                            $tagNames[] = $tag->name;
                                                        }
                                                    }
                                                }
                                                $tagDisplay = !empty($tagNames) ? implode(', ', $tagNames) : 'Tidak ada tags';
                                            @endphp
                                            {{ $tagDisplay }}
                                        </td>
                                        <td>{{ $post->createdBy ? $post->createdBy->name : 'Tidak diketahui' }}</td>
                                        <td>{{ $post->updatedBy ? $post->updatedBy->name : 'Tidak diperbarui' }}</td>
                                        <td>{{ $post->published_at ? $post->published_at->format('d M Y H:i') : 'Belum dipublikasikan' }}</td>
                                        <td>{{ $post->created_at->format('d M Y H:i') }}</td>
                                        <td>{{ $post->updated_at->format('d M Y H:i') }}</td>
                                        <td>
                                            @can('edit posts')
                                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            @endcan
                                            @can('delete posts')
                                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
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
                        <div class="pagination-container">
                            {{ $posts->links('pagination::bootstrap-4') }}
                        </div>
                    @else
                        <p class="text-danger">Anda tidak memiliki izin untuk melihat daftar post.</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <style>
        .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center; 
            min-height: 60px; 
            margin-top: 20px; 
        }
    </style>
@endpush
@push('scripts')
    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#datatable-responsive')) {
                $('#datatable-responsive').DataTable().destroy();
            }
            $('#datatable-responsive').DataTable({
                paging: false,
                info: false
            });
        });
    </script>
@endpush