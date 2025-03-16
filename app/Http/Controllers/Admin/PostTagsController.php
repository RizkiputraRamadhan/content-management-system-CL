<?php

namespace App\Http\Controllers\Admin;

use App\Models\PostTags;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PostTagsController extends Controller
{
    public function index()
    {
        $tags = PostTags::all();
        return view('pages.admin.tags.index', [
            'tags' => $tags
        ])->with('page', 'Tags');
    }

    public function create()
    {
        return view('pages.admin.tags.create')->with('page', 'Tags');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:post_tags,name',
        ]);

        $validatedData['slug'] = Str::slug($request->name);
        
        PostTags::create($validatedData);

        return redirect()->route('tags.index')->with('success', 'Tags created successfully');
    }

    public function edit($id)
    {
        $tags = PostTags::findOrFail($id);
        return view('pages.admin.tags.edit', [
            'tags' => $tags
        ])->with('page', 'Tags');
    }

    public function update(Request $request, $id)
    {
        $tags = PostTags::findOrFail($id);
        $validatedData['slug'] = Str::slug($request->name);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:post_tags,name,' . $id,
        ]);
    
        $tags->update($validatedData);
    
        return redirect()->route('tags.index')->with('success', 'Tags updated successfully');
    }

    public function destroy($id)
    {
        $tags = PostTags::findOrFail($id);
        $tags->delete();

        return redirect()->route('tags.index')->with('success', 'Tags deleted successfully');
    }
}