<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item; 

class PurchaseController extends Controller
{
    // 購入ページ表示。Itemモデルを受け取る
    public function showPurchasePage(Item $item)
    {
        $user = Auth::user();
        return view('purchase', compact('user', 'item'));
    }

    // 購入処理
    public function purchase(Item $item)
    {
        if ($item->is_sold) {
            return redirect()->route('index')->with('status', 'この商品はすでに購入済みです');
        }

        $item->is_sold = true;
        $item->save();

        return redirect()->route('index')->with('status', '購入しました');        
    }
}
