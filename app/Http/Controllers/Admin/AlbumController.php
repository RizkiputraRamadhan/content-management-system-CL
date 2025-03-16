<?php

namespace App\Http\Controllers\Admin;

use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Menampilkan daftar album
     */
    public function index()
    {
        return view('pages.admin.albums.index', [
            'albums' => Album::orderBy('id', 'desc')
                ->with(['photos'])
                ->get(),
        ])->with('page', 'Galery');
    }

    /**
     * Menampilkan form untuk membuat album baru
     */
    public function create()
    {
        return view('pages.admin.albums.create')->with('page', 'Galery');
    }

    /**
     * Menyimpan album baru ke database
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:albums,name',
            'description' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:2048',
        ]);

        $validatedData['slug'] = Str::slug($request->name);
        $validatedData['created_by'] = auth()->id();

        try {
            $album = Album::create($validatedData);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    if ($photo->isValid()) {
                        $path = $photo->store('public/albums/' . $album->id);
                        AlbumPhoto::create([
                            'image' => basename($path),
                            'album_id' => $album->id,
                        ]);
                    }
                }

                return response()->json([
                    'success' => true,
                    'message' => 'Album created successfully',
                    'redirect' => route('album.index'),
                ]);
            }

            return redirect()->route('album.index')->with('success', 'Album created successfully');
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * Menampilkan form untuk mengedit album
     */
    public function edit($id)
    {
        $album = Album::findOrFail($id);
        return view('pages.admin.albums.edit', [
            'album' => $album,
        ])->with('page', 'Galery');
    }

    /**
     * Memperbarui data album di database
     */
    public function update(Request $request, $id)
    {
        $album = Album::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:albums,name,' . $id,
            'description' => 'nullable|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|max:2048',
        ]);

        $validatedData['slug'] = Str::slug($request->name);

        try {
            $album->update($validatedData);

            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    if ($photo->isValid()) {
                        $path = $photo->store('public/albums/' . $album->id);
                        AlbumPhoto::create([
                            'image' => basename($path),
                            'album_id' => $album->id,
                        ]);
                    }
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Album updated successfully',
                    'redirect' => route('album.index'),
                ]);
            }
            return redirect()->route('album.index')->with('success', 'Album updated successfully');
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                ],
                500,
            );
        }
    }
    public static function destroyPhoto($albumId, $photoId)
    {
        $photo = AlbumPhoto::where('album_id', $albumId)->findOrFail($photoId);
        $photo->delete();
        Storage::delete('public/albums/' . $albumId . '/' . $photo->image);

        return response()->json(['message' => 'Foto berhasil dihapus']);
    }

    /**
     * Menghapus album dari database
     */
    public function destroy($id)
    {
        $album = Album::findOrFail($id);
        foreach ($album->photos as $photo) {
            $this->destroyPhoto($album->id, $photo->id);
        }
        $album->delete();

        return redirect()->route('album.index')->with('success', 'Album deleted successfully');
    }
}
