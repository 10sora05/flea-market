<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user(); // ログインユーザーを取得

        return view('profile.edit', compact('user')); // ← Blade に渡す
    }
    public function update(Request $request)
    {
        $request->validate([
            'img' => 'nullable|image|mimes:jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'post' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string|max:255',
            'bldg' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        // 画像の保存
        if ($request->hasFile('img')) {
            $path = $request->file('img')->store('images', 'public'); // storage/app/public/images に保存
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
