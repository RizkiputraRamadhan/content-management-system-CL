<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\FileHelper;
use App\Models\Posts;
use App\Models\PostTags;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function index()
    {
        return view('pages.admin.posts.index', [
            'posts' => Posts::orderBy('id', 'desc')->paginate(10),
            'tags' => PostTags::orderBy('id', 'desc')->get(),
        ])->with('page', 'Postingan');
    }

    public function create()
    {
        $data = [
            'categories' => PostCategory::orderBy('id', 'desc')->get(),
            'tags' => PostTags::orderBy('id', 'desc')->get(),
        ];
        return view('pages.admin.posts.create', $data)->with('page', 'Postingan');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'category_id' => 'nullable|exists:post_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:post_tags,id',
            'published_at' => 'nullable|date',
        ]);

        $validatedData['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $validatedData['image'] = FileHelper::saveFile($request->file('image'), 'posts', 'image');
        }


        if ($request->has('tags')) {
            $validatedData['tags'] = json_encode($request->tags);
        }
        $validatedData['created_by'] = auth()->id();
        $validatedData['counter'] = 0;
        Posts::create($validatedData);

        return redirect()->route('posts.index')->with('success', 'Post berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = [
            'categories' => PostCategory::orderBy('id', 'desc')->get(),
            'tags' => PostTags::orderBy('id', 'desc')->get(),
            'post' => Posts::findOrFail($id),
        ];
        return view('pages.admin.posts.edit', $data)->with('page', 'Postingan');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'category_id' => 'nullable|exists:post_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:post_tags,id',
            'published_at' => 'nullable|date',
        ]);

        try {
            $post = Posts::findOrFail($id);
            $validatedData['slug'] = Str::slug($request->title);

            if ($request->hasFile('image')) {
                $validatedData['image'] = FileHelper::saveFile($request->file('image'), 'posts', 'image');
            }

            if ($request->has('tags')) {
                $validatedData['tags'] = json_encode($request->tags);
            } else {
                $validatedData['tags'] = json_encode([]);
            }

            $validatedData['updated_by'] = auth()->id();

            $post->update($validatedData);

            return redirect()->route('posts.index')->with('success', 'Postingan berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Failed to update post: ' . $e->getMessage());
            return redirect()
                ->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui postingan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $posts = Posts::findOrFail($id);
        $posts->delete();

        return redirect()->route('posts.index')->with('success', 'Postingan deleted successfully');
    }
}
