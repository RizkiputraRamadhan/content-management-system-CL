<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadImageEditor extends Controller
{
    # image handleler
    public function uploadImage(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $randomName = 'image_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = public_path('assets/app/image-editor');

            // Pastikan folder ada
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true);
            }

            $file->move($path, $randomName);
            $url = asset('assets/app/image-editor/' . $randomName);

            return response()->json(['url' => $url], 200);
        }
        return response()->json(['error' => 'No file uploaded'], 400);
    }

    public function deleteImage(Request $request)
    {
        $imagePath = $request->input('image_path');
        if ($imagePath && File::exists(public_path($imagePath))) {
            File::delete(public_path($imagePath));
            return response()->json(['success' => 'Image deleted successfully'], 200);
        }

        return response()->json(['error' => 'Image not found'], 404);
    }
}
