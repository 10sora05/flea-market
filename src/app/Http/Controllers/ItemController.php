<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        $likedItems = auth()->user() ? auth()->user()->likedItems : collect();
        
        return view('index', compact('items', 'likedItems'));
    }

    public function search(Request $request)
    {
        $keyword = $request->get('keyword');

        $items = Item::where('name', 'like', '%' . $keyword . '%')->get();

        return response()->json($items);
    }

    public function show($id)
    {
        $item = Item::with(['comments.user', 'condition'])->findOrFail($id);

        $item = Item::with('categories')->findOrFail($id);
        
        return view('detail', compact('item'));

    }

    public function purchase($id)
    {
        $item = Item::findOrFail($id);
        return view('purchase', compact('item'));
    }

    public function store(Request $request)
    {
        $item = Item::create(['name' => $request->name]);
        $item->categories()->sync($request->category_ids);
        
    }
}
