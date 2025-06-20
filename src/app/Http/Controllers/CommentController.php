<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Comment;
use App\Http\Requests\CommentRequest;


class CommentController extends Controller
{
    public function store(CommentRequest $request, Item $item)
    {
        Comment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'コメントを投稿しました。');
    }
}
