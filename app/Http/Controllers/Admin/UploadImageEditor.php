<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadImageEditor extends Controller
{
    # image handleler
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $path = $file->store('public/images');
            $url = Storage::url($path);

            return response()->json(['url' => $url], 200);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function deleteImage(Request $request)
    {
        $imagePath = $request->input('image_path');

        if (Storage::exists('public/' . $imagePath)) {
            Storage::delete('public/' . $imagePath);
            return response()->json(['success' => 'Image deleted successfully'], 200);
        }

        return response()->json(['error' => 'Image not found'], 404);
    }
}
