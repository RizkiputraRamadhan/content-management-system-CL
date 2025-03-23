<?php

namespace App\Http\Controllers\Admin;

use App\Models\Video;
use App\Helpers\FileHelper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class VideosController extends Controller
{
    public function index()
    {
        $video = Video::orderBy('id', 'desc')->get();
        return view('pages.admin.video.index', compact('video'))->with('page', 'Video');
    }

    public function create()
    {
        return view('pages.admin.video.create')->with('page', 'Video');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link_yt' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $videoData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'link_yt' => $request->link_yt,
            'description' => $request->description,
            'created_by' => auth()->user()->id,
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $videoData['image'] = FileHelper::saveFile($request->file('image'), 'videos', 'image');
        } else {
            $videoData['image'] = 'default.jpg';
        }

        Video::create($videoData);

        return redirect()->route('video.index')->with('success', 'Video berhasil dibuat');
    }

    public function edit($id)
    {
        $video = Video::find($id);
        return view('pages.admin.video.edit', compact('video'))->with('page', 'Video');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link_yt' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $video = Video::find($id);
        
        $videoData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'link_yt' => $request->link_yt,
            'description' => $request->description,
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($video->image && $video->image !== 'default.jpg') {
                Storage::disk('public')->delete('videos/' . $video->image);
                FileHelper::deleteFile($video->image);
            }
            $videoData['image'] = FileHelper::saveFile($request->file('image'), 'videos', 'image');
        }

        $video->update($videoData);

        return redirect()->route('video.index')->with('success', 'Video berhasil diperbarui');
    }

    public function destroy($id)
    {
        $video = Video::find($id);
        if ($video->image && $video->image !== 'default.jpg') {
            Storage::disk('public')->delete('videos/' . $video->image);
        }

        $video->delete();

        return redirect()->route('video.index')->with('success', 'Video deleted successfully');
    }
}
