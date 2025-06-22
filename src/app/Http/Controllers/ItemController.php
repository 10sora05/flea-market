<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
        {
            $items = Item::latest()->take(12)->get();
            return view('index', compact('items'));
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
            return view('detail', compact('item'));
        }

    public function purchase($id)
        {
            $item = Item::findOrFail($id);
            return view('purchase', compact('item'));
        }
        

}
