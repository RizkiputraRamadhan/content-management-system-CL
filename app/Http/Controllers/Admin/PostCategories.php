<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class PostCategories extends Controller
{
    public function index()
    {
        $categories = PostCategory::all();
        return view('pages.admin.categories.index', [
            'categories' => $categories
        ])->with('page', 'Kategori');
    }

    public function create()
    {
        return view('pages.admin.categories.create')->with('page', 'Kategori');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:post_categories,name',
        ]);
        $validatedData['slug'] = Str::slug($request->name);
        PostCategory::create($validatedData);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function edit($id)
    {
        $category = PostCategory::findOrFail($id);
        return view('pages.admin.categories.edit', [
            'category' => $category
        ])->with('page', 'Kategori');
    }

    public function update(Request $request, $id)
    {
        $category = PostCategory::findOrFail($id);
    
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:post_categories,name,' . $id,
        ]);
        $validatedData['slug'] = Str::slug($request->name);
        $category->update($validatedData);
    
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $category = PostCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}