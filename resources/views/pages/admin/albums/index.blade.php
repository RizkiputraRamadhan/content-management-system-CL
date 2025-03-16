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
                    @can('create album')
                        <div class="panel-action">
                            <a href="{{ route('album.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Tambah Data
                            </a>
                        </div>
                    @endcan

                    @can('view album')
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tautan</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($albums as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="/album/{{ $row->slug }}" target="_blank" rel="noopener noreferrer"><i
                                            class="fa fa-external-link"></i> Lihat</a></td>
                                        <td>{{ $row->name }}</td>
                                        <td>
                                            @can('edit album')
                                                <a href="{{ route('album.edit', $row->id) }}" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            @endcan
                                            @can('delete album')
                                                <form action="{{ route('album.destroy', $row->id) }}" method="POST"
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
                        <p class="text-danger">Anda tidak memiliki izin untuk melihat daftar row.</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
