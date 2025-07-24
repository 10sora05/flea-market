@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsectionmy

@section('content')
<div class="edit-content">
    <div class="user-profile">
        <div class="user-profile__image">
            <img src="{{ $user->img ? asset('storage/' . $user->img) : asset('images/default-user.png') }}" alt="ユーザー画像" class="user-img">
        </div>
        <div class="user-profile__info">
            <h2 class="user-name">{{ $user->name }}</h2>
            <a class="profile-edit-link" href="{{ route('profile.edit') }}">プロフィールを編集</a>
        </div>
    </div>

    <div class="tab-buttons">
        <button onclick="showTab('sell')">出品した商品</button>
        <button onclick="showTab('buy')">購入した商品</button>
    </div>

    <div id="sell" class="tab-content">
        <h2>出品した商品</h2>
        @forelse ($sellingItems as $item)
            <div class="item-card">
                <div class="index__item-img">
                    <a href="{{ route('items.show', $item->id) }}">
                        <img
                            src="{{ $item->img_url ? $item->img_url : asset('storage/' . $item->image_path) }}"
                            alt="商品画像"
                            class="item-img">
                    </a>
                </div>
                <div class="index__item-name">
                    <a href="{{ route('items.show', $item->id) }}" class="item-name__a">
                        <h2 class="update-form__item-name">{{ $item->name }}</h2>
                    </a>
                </div>
            </div>
        @empty
            <p>出品した商品はありません。</p>
        @endforelse
    </div>

    <div id="buy" class="tab-content" style="display: none;">
        <h2>購入した商品</h2>
        @forelse ($purchasedItems as $item)
            <div class="item-card">
                <div class="index__item-img">
                    <a href="{{ route('items.show', $item->id) }}">
                        <img
                            src="{{ $item->img_url ? $item->img_url : asset('storage/' . $item->image_path) }}"
                            alt="商品画像"
                            class="item-img">
                    </a>
                </div>
                <div class="index__item-name">
                    <a href="{{ route('items.show', $item->id) }}" class="item-name__a">
                        <h2 class="update-form__item-name">{{ $item->name }}</h2>
                    </a>
                </div>
            </div>
        @empty
            <p>購入した商品はありません。</p>
        @endforelse
    </div>
</div>

<script>
function showTab(type) {
    document.getElementById('sell').style.display = (type === 'sell') ? 'block' : 'none';
    document.getElementById('buy').style.display = (type === 'buy') ? 'block' : 'none';
}
</script>

@endsection