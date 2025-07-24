<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

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
        $item = new Item();
        $item->name = $request->name;
        $item->description = $request->description;
        $item->price = $request->price;
        $item->seller_id = Auth::id();
        $item->is_sold = false;
        $item->save();

        return redirect()->route('index')->with('status', '商品を出品しました');
    }
}
