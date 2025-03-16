<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    # Menampilkan daftar role
    public function indexRoles()
    {
        $roles = Role::all();
        return view('pages.admin.roles.index', compact('roles'))->with('page', 'Roles');
    }

    # Menampilkan daftar permission
    public function indexPermissions()
    {
        $permissions = Permission::all();
        return view('pages.admin.permissions.index', compact('permissions'))->with('page', 'Permissions');
    }

    # Menampilkan form untuk membuat role baru
    public function createRole()
    {
        $permissions = Permission::all();
        return view('pages.admin.roles.create', compact('permissions'))->with('page', 'Roles');
    }

    # Menyimpan role baru ke database
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permissions' => 'array',
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Nama role sudah ada, gunakan nama lain.',
        ]);

        $role = Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat dengan permission yang dipilih.');
    }

    # Menampilkan form untuk mengedit role
    public function editRole(Role $role)
    {
        $permissions = Permission::all();
        return view('pages.admin.roles.edit', compact('role', 'permissions'))->with('page', 'Roles');
    }

    # Memperbarui data role di database
    public function updateRole(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permissions' => 'array',
        ], [
            'name.required' => 'Nama role wajib diisi.',
            'name.unique' => 'Nama role sudah ada, gunakan nama lain.',
        ]);

        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions ?? []); 

        return redirect()->route('roles.index')->with('success', 'Role berhasil diperbarui.');
    }

    # Menghapus role dari database
    public function destroyRole(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Role berhasil dihapus.');
    }

    # Menampilkan form untuk membuat permission baru
    public function createPermission()
    {
        return view('pages.admin.permissions.create')->with('page', 'Permissions');
    }

    # Menyimpan permission baru ke database
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name',
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique' => 'Nama permission sudah ada, gunakan nama lain.',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dibuat.');
    }

    # Menampilkan form untuk mengedit permission
    public function editPermission(Permission $permission)
    {
        return view('pages.admin.permissions.edit', compact('permission'))->with('page', 'Permissions');
    }

    # Memperbarui data permission di database
    public function updatePermission(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ], [
            'name.required' => 'Nama permission wajib diisi.',
            'name.unique' => 'Nama permission sudah ada, gunakan nama lain.',
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil diperbarui.');
    }

    # Menghapus permission dari database
    public function destroyPermission(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permission berhasil dihapus.');
    }
}