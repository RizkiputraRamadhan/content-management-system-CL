<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\Menus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class MenusController extends Controller
{
    public function index()
    {
        $data = [
            'menus' => Menus::orderBy('order', 'asc')->get(),
        ];

        return view('pages.admin.menus.index', $data)->with('page', 'Menu');
    }

    public function create()
    {
        $data = [
            'parent' => Menus::where('type_1', 'parent')->get(),
            'pages' => Page::orderBy('id', 'desc')->get(),
        ];
        return view('pages.admin.menus.create', $data)->with('page', 'Menu');
    }

    public function edit($id)
    {
        $menu = Menus::findOrFail($id);
        $data = [
            'menu' => $menu,
            'parent' => Menus::where('type_1', 'parent')->get(),
            'pages' => Page::orderBy('id', 'desc')->get(),
        ];
    
        if ($menu->type_2 === 'page' && $menu->slug) {
            $page = Page::where('slug', $menu->slug)->first(); // Menggunakan first() untuk mendapatkan satu record
            if ($page) {
                $data['selected_page_id'] = $page->id; // Tambahkan page_id yang dipilih ke data
            }
        }
    
        return view('pages.admin.menus.edit', $data)->with('page', 'Menu');
    }

    public function update(Request $request, $id)
    {
        $menu = Menus::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'type_1' => 'required|in:parent,submenu',
            'type_2' => 'required|in:page,link',
            'parent_id' => 'nullable|exists:menus,id',
            'page_id' => 'nullable|exists:pages,id',
            'slug' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        if ($request->type_2 === 'page' && $request->page_id) {
            $page = Page::findOrFail($request->page_id);
            $validatedData['slug'] = $page->slug;
        }

        if ($request->type_1 === 'parent') {
            $validatedData['parent_id'] = null;
        }

        $menu->update($validatedData);
        return redirect()->route('menu.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'type_1' => 'required|in:parent,submenu',
            'type_2' => 'required|in:page,link',
            'slug' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ];

        if ($request->input('type_2') === 'page') {
            $rules['page_id'] = 'required|exists:pages,id';
        }

        $request->validate($rules);

        $maxOrder = Menus::max('order') ?? 0;
        $newOrder = $maxOrder + 1;

        Menus::create([
            'name' => $request->name,
            'slug' => $request->slug,
            'type_1' => $request->input('type_1'),
            'type_2' => $request->input('type_2'),
            'parent_id' => $request->parent_id,
            'status' => $request->status,
            'order' => $newOrder,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('menu.index')->with('success', 'Menu berhasil ditambahkan');
    }

    public function updateOrder(Request $request)
    {
        $orderData = $request->json()->all();

        if (!is_array($orderData) || empty($orderData)) {
            Log::error('Invalid order data:', ['data' => $orderData]);
            return response()->json(['success' => false, 'message' => 'Invalid order data'], 400);
        }

        try {
            foreach ($orderData as $item) {
                if (!isset($item['id']) || !isset($item['order'])) {
                    throw new \Exception('Invalid item format: missing id or order');
                }
                Menus::where('id', $item['id'])->update(['order' => $item['order']]);
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error updating order:', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'Failed to update order'], 500);
        }
    }

    public function destroy($id)
    {
        $menu = Menus::findOrFail($id);
        $submenus = Menus::where('parent_id', $menu->id)->get();
        foreach ($submenus as $submenu) {
            $submenu->update([
                'type_1' => 'parent',
                'parent_id' => null,
            ]);
        }
        $menu->delete();
        return response()->json(['success' => true]);
    }
}
