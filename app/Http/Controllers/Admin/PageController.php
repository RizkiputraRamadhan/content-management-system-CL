<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    # Display a listing of pages
    public function index()
    {
        $pages = Page::all();
        return view('pages.admin.page.index', compact('pages'))->with('page', 'Halaman');
    }

    # Show the form for creating a new page
    public function create()
    {
        return view('pages.admin.page.create')->with('page', 'Halaman');
    }

    # Store a newly created page in storage
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        $data['slug'] = slugVerified($request->title);
        $data['created_by'] = auth()->id(); 

        Page::create($data);

        return redirect()->route('pages.index')->with('success', 'Halaman berhasil ditambahkan.');
    }

    # Show the form for editing the specified page
    public function edit($page)
    {
        $edit = Page::find($page);
        return view('pages.admin.page.edit', compact('edit'))->with('page', 'Halaman');
    }

    # Update the specified page in storage
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $data = $request->all();
        // $data['slug'] = slugVerified($request->title); 

        $page->update($data);

        return redirect()->route('pages.index')->with('success', 'Halaman berhasil diperbarui.');
    }

    # Remove the specified page from storage
    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with('success', 'Halaman berhasil dihapus.');
    }
}