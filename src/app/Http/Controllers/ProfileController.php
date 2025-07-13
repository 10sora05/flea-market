<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user(); // ログインユーザーを取得

        return view('profile.edit', compact('user')); // ← Blade に渡す
    }
    public function update(AddressRequest $request)
    {
        $user = auth()->user();

        // 画像の保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $user->img = $path;
}

        // その他の更新
        $user->name = $request->name;
        $user->post = $request->post;
        $user->address = $request->address;
        $user->bldg = $request->bldg;
        $user->save();

        return redirect()->back()->with('success', 'プロフィールを更新しました');
    }
}
