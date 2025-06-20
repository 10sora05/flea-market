<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Like;

class LikeController extends Controller
{
    public function like(Item $item)
    {
        $item->likes()->firstOrCreate([
            'user_id' => Auth::id(),
        ]);

        return response()->json(['liked' => true]);
    }

    public function unlike(Item $item)
    {
        $item->likes()->where('user_id', Auth::id())->delete();

        return response()->json(['liked' => false]);
    }
}
