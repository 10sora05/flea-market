<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Item;

class SellController extends Controller
{
    public function create()
        {
            return view('sell');
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        // 画像保存
        if ($request->hasFile('image')) {
            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $data['image_path'] = $request->file('image')->storeAs('images', $filename, 'public');
        }

        // カテゴリーは配列として保存などの処理が必要です（例: JSON化）
        $data['categories'] = json_encode($request->categories);

        // 商品保存（仮）
        Item::create($data);

        return redirect()->route('sell')->with('success', '商品を出品しました');

    }
}
