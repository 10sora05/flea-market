<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;
use App\Models\Category;

class SellController extends Controller
{
    public function create()
    {
        $conditions = \App\Models\Condition::all();
        return view('sell', compact('conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $categoryIds = Category::whereIn('slug', $request->categories)->pluck('id')->toArray();

        if (empty($categoryIds)) {
            return back()->withErrors(['categories' => '正しいカテゴリーを選択してください']);
        }

        // 画像アップロード処理
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
        }

        // アイテム保存
        $item = Item::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'description' => $request->description,
            'price' => $request->price,
            'condition_id' => $request->condition_id,
            'image_path' => $imagePath,
            'seller_id' => auth()->id(),
        ]);

        $item->categories()->attach($categoryIds);

        return redirect()->route('index')->with('success', '商品を出品しました！');
    }
}
