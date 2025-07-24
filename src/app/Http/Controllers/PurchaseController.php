<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item; 

class PurchaseController extends Controller
{
    public function showPurchasePage(Item $item)
    {
        $user = Auth::user();
        return view('purchase', compact('user', 'item'));
    }

    public function purchase(Item $item)
    {
        $user = Auth::user();

        if ($item->is_sold || $item->buyer_id !== null) {
            return redirect()->route('index')->with('status', 'この商品はすでに購入済みです');
        }

        $item->is_sold = true;
        $item->buyer_id = $user->id;
        $item->save();

        return redirect()->route('index')->with('status', '購入しました');
    }
}
