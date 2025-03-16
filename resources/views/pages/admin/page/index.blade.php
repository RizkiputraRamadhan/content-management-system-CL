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
                    @can('create pages')
                        <div class="panel-action">
                            <a href="{{ route('pages.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Tambah Halaman
                            </a>
                        </div>
                    @endcan
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Tautan</th>
                                <th>Status</th>
                                <th>Dibuat Oleh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pages as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row->title }}</td>
                                    <td><a href="/page/{{ $row->slug }}" target="_blank" rel="noopener noreferrer"><i
                                                class="fa fa-external-link"></i> Lihat</a></td>
                                    <td>{{ $row->status }}</td>
                                    <td>{{ $row->creator->name }}</td>
                                    <td>
                                        @can('edit pages')
                                            <a href="{{ route('pages.edit', $row->id) }}" class="btn btn-primary btn-xs">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                        @endcan

                                        @can('delete pages')
                                            <form action="{{ route('pages.destroy', $row->id) }}" method="POST"
                                                class="delete-form" style="display: inline;"
                                                onsubmit="return confirmDelete(this)">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs show_confirm">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
