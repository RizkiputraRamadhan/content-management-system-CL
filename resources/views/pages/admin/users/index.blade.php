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
                    @can('create users')
                        <div class="panel-action">
                            <a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i> Tambah Data
                            </a>
                        </div>
                    @else
                        <div class="panel-action">
                            <p class="text-muted">Anda tidak memiliki izin untuk menambah data user.</p>
                        </div>
                    @endcan

                    @can('view users')
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tautan</th>
                                    <th>Email</th>
                                    <th>Gambar</th>
                                    <th>Status</th>
                                    <th>Role</th>
                                    <th>Nomor Telepon</th>
                                    <th>Dibuat Pada</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}.</td>
                                        <td>{{ $user->name }}</td>
                                        <td><a href="/author/{{ $user->slug }}" target="_blank" rel="noopener noreferrer"><i
                                                    class="fa fa-external-link"></i> Lihat</a></td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if ($user->image)
                                                <img src="{{ getFile($user->image) }}" alt="{{ $user->name }}"
                                                    style="max-width: 50px;">
                                            @else
                                                Tidak Ada Gambar
                                            @endif
                                        </td>
                                        <td>{{ $user->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</td>
                                        <td>{{ ucfirst($user->getRoleNames()->first() ?? 'Tidak Ada Role') }}</td>
                                        <td>{{ $user->phone_number ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($user->created_at)->translatedFormat('d F Y H:i') }}</td>
                                        <td>
                                            @can('edit users')
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-xs">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                            @endcan

                                            @can('delete users')
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                    class="delete-form" style="display: inline;" onsubmit="return confirmDelete(this)">
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
                    @else
                        <p class="text-danger">Anda tidak memiliki izin untuk melihat data user.</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
@endpush
