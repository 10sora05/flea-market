<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // プロフィール編集ページ表示
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    // プロフィール更新処理
    public function update(AddressRequest $request)
    {
        $user = auth()->user();

        // 画像がアップロードされた場合、保存処理
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $user->img = $path;
        }

        // `name` が送信されている場合のみ更新
        if ($request->has('name')) {
            $user->name = $request->name;
        }

        $user->post = $request->post;
        $user->address = $request->address;
        $user->bldg = $request->bldg;
        $user->save();

        return redirect()->route('index')->with('status', 'プロフィールが更新されました');
    }

    // 住所変更ページの表示
    public function address()
    {
        $user = Auth::user();
        return view('profile.address', compact('user'));
    }

    // 住所更新処理
    public function addressUpdate(AddressRequest $request)
    {
        // ログインユーザーを取得
        $user = Auth::user();

        // 住所情報を更新
        $user->post = $request->post;
        $user->address = $request->address;
        $user->bldg = $request->bldg ?? ''; // 建物名が空なら空文字にする
        $user->save();

        // 更新後に `purchase` ページにリダイレクト
        return redirect()->route('purchase')->with('status', '住所が更新されました');
    }
}
