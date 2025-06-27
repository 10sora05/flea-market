<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();  // 現在のログインユーザーを取得
        return view('mypage', compact('user'));  // ビューに$userを渡す
    }

    public function update(Request $request)
    {
        $user = Auth::user();  // 現在のユーザーを取得

        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'post' => 'nullable|digits:7',
            'address' => 'nullable|string|max:255',
            'bldg' => 'nullable|string|max:255',
            'img' => 'nullable|image|max:2048',
        ]);

        // ユーザー情報を更新
        $user->name = $request->name;
        $user->post = $request->post;
        $user->address = $request->address;
        $user->bldg = $request->bldg;

        if ($request->hasFile('img')) {
            // 画像を public ディスクに保存（storage/app/public/images）
            $path = $request->file('img')->store('images', 'public');
            $user->img = $path;
        }

        $user->save();  // ユーザーを保存

        return redirect()->route('profile.edit')->with('success', 'プロフィールを更新しました。');
    }
}
