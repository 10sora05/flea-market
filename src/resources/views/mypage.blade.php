@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="mypage-content">
    <h2 class="mypage-h2">プロフィール設定</h2>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="user-information">
            @if(optional($user)->img)
                <img src="{{ asset('storage/' . $user->img) }}" alt="ユーザー画像" class="user-icon-img" />
            @else
                <div class="user-icon-placeholder">No Image</div>
            @endif

            <input type="file" accept="image/*" name="img" class="user-img" />
            @error('img') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="user-information">
            <label for="name" class="user-title">ユーザー名</label>
            <input id="name" type="text" name="name" class="user-input" value="{{ old('name', $user->name ?? '') }}" autofocus>
            @error('name') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="user-information">
            <label for="post" class="user-title">郵便番号</label>
            <input type="number" name="post" class="user-input" value="{{ old('post', $user->post ?? '') }}"/>
            @error('post') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="user-information">
            <label for="address" class="user-title">住所</label>
            <input id="address" type="text" name="address" class="user-input" value="{{ old('address', $user->address ?? '') }}">
            @error('address') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="user-information">
            <label for="bldg" class="user-title">建物名</label>
            <input id="bldg" type="text" name="bldg" class="user-input" value="{{ old('bldg', $user->bldg ?? '') }}">
            @error('bldg') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="user-information">
            <button type="submit" class="mypage-form-button">
                更新する
            </button>
        </div>
    </form>
</div>

@endsection
