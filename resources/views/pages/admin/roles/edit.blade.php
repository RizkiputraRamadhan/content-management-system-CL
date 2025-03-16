@extends('layouts.admin.app')
@section('title', $page)
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit {{ $page }}</h3>
                </div>
                <div class="panel-body">
                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Nama Role</label>
                            <input type="text" name="name" class="form-control" value="{{ $role->name }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Pilih Permission</label>
                            <div class="checkbox checkbox-success">
                                <input id="select-all" type="checkbox">
                                <label for="select-all">
                                    Pilih Semua
                                </label>
                            </div>
                            <div class="row">
                                @php
                                    $permissionsCount = $permissions->count();
                                    $halfCount = ceil($permissionsCount / 2); 
                                    $firstColumn = $permissions->take($halfCount);
                                    $secondColumn = $permissions->skip($halfCount);
                                @endphp

                                <div class="col-md-6">
                                    @foreach ($firstColumn as $permission)
                                        <div class="checkbox checkbox-success">
                                            <input id="id-{{ $permission->id }}" type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="permission-checkbox" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <label for="id-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="col-md-6">
                                    @foreach ($secondColumn as $permission)
                                        <div class="checkbox checkbox-success">
                                            <input id="id-{{ $permission->id }}" type="checkbox" name="permissions[]" value="{{ $permission->name }}" class="permission-checkbox" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                            <label for="id-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @error('permissions')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">Update</button>
                        <a href="{{ route('roles.index') }}" class="btn btn-default">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.permission-checkbox');
            const selectAll = document.getElementById('select-all');
            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
            selectAll.checked = allChecked;
        });
    </script>
@endpush