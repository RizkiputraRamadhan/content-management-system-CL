<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.admin.users.index', compact('users'))->with('page', 'Users');
    }

    public function create()
    {
        return view('pages.admin.users.create')->with('page', 'Users');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'nullable|numeric|digits_between:10,13|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'image' => 'nullable|image|max:2048',
            'status' => 'in:active,inactive',
            'role' => 'required|exists:roles,name',
        ]);

        $userData = $request->all();
        $userData['slug'] = slugVerified($request->name);
        $userData['password'] = Hash::make($request->password);

        if ($request->hasFile('image')) {
            $userData['image'] = $request->file('image')->store('user-images', 'public');
        }

        $user = User::create($userData);
        $user->assignRole($request->input('role'));

        return redirect()
            ->route('users.index')
            ->with('success', 'User berhasil dibuat dengan role ' . ucfirst($request->input('role')));
    }

    public function edit(User $user)
    {
        return view('pages.admin.users.edit', compact('user'))->with('page', 'Users');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|numeric|digits_between:10,13|unique:users,phone_number,' . $user->id,
            'password' => 'nullable|string|min:3|confirmed',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:active,inactive',
            'role' => 'required|exists:roles,name',
        ]);

        $userData = $request->all();
        $userData['slug'] = slugVerified($request->name);

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        } else {
            unset($userData['password']);
        }

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $userData['image'] = $request->file('image')->store('user-images', 'public');
        }

        $user->update($userData);

        $user->syncRoles([$request->input('role')]);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully');
    }



    #update user profile
    public function profil() {
        $data = [
            'user' => User::find(Auth::user()->id)
        ];
        return view('pages.admin.profil.index',  $data)->with('page', 'Akun Pribadi');
    }

    public function profilUpdate(Request $request)
    {
        $user =  User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|numeric|digits_between:10,13|unique:users,phone_number,' . $user->id,
            'password' => 'nullable|string|min:3|confirmed',
            'image' => 'nullable|image|max:2048',
        ]);

        $userData = $request->all();
        $userData['slug'] = slugVerified($request->name);

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        } else {
            unset($userData['password']);
        }

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image);
            }
            $userData['image'] = $request->file('image')->store('user-images', 'public');
        }

        $user->update($userData);

        return redirect()->back()->with('success', 'Akun berhasil diperbarui');
    }
}
