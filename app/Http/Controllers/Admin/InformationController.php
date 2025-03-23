<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Models\Information;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class InformationController extends Controller
{
    public function index(Request $request)
    {
        $query = Information::orderBy('id', 'desc');

        if ($request->has('type') && in_array($request->type, ['banner', 'text'])) {
            $query->where('type', $request->type);
        }

        $information = $query->get();
        return view('pages.admin.information.index', compact('information'))->with('page', 'Informasi');
    }

    public function create()
    {
        return view('pages.admin.information.create')->with('page', 'Informasi');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => [
                'nullable',
                'image',
                'max:2048', // Max size in KB (2MB)
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->type === 'banner' && $request->hasFile('image')) {
                        $image = $request->file('image');
                        if ($image->isValid()) {
                            [$width, $height] = getimagesize($image->path());
                            if ($width <= $height) {
                                $fail('Banner harus berukuran landscape (lebar lebih besar dari tinggi).');
                            }
                        }
                    }
                },
            ],
            'description' => 'nullable|string',
            'type' => 'required|string|in:banner,text',
        ]);

        $informationData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'type' => $request->type,
            'description' => $request->description,
            'created_by' => auth()->user()->id,
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $informationData['image'] = FileHelper::saveFile($request->file('image'), 'banners', 'image');
        }

        Information::create($informationData);

        return redirect()->route('information.index')->with('success', 'Information berhasil dibuat');
    }

    public function edit($id)
    {
        $information = Information::find($id);
        return view('pages.admin.information.edit', compact('information'))->with('page', 'Informasi');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => [
                'nullable',
                'image',
                'max:2048',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->type === 'banner' && $request->hasFile('image')) {
                        $image = $request->file('image');
                        if ($image->isValid()) {
                            [$width, $height] = getimagesize($image->path());
                            if ($width <= $height) {
                                $fail('Banner harus berukuran landscape (lebar lebih besar dari tinggi).');
                            }
                        }
                    }
                },
            ],
            'description' => 'nullable|string',
            'type' => 'required|string|in:banner,text',
        ]);

        $information = Information::find($id);

        $informationData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'type' => $request->type,
            'description' => $request->description,
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($information->image) {
                FileHelper::deleteFile($information->image);
            }
            $informationData['image'] = FileHelper::saveFile($request->file('image'), 'banners', 'image');
        }

        $information->update($informationData);

        return redirect()->route('information.index')->with('success', 'Information berhasil diperbarui');
    }

    public function destroy($id)
    {
        $information = Information::find($id);
        if ($information->image) {
            FileHelper::deleteFile($information->image);
        }

        $information->delete();

        return redirect()->route('information.index')->with('success', 'Information deleted successfully');
    }
}
