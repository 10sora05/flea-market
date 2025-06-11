<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
        {
            $items = Item::take(8)->get();
            return view('index', compact('items'));
        }

    public function show($id)
        {
            $item = Item::findOrFail($id);
            return view('detail', compact('item'));
        }

    public function purchase($id)
        {
            $item = Item::findOrFail($id);
            return view('purchase', compact('item'));
        }

}
