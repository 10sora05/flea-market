@extends('layouts.app')

@section('body_class', 'page-mypage')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="edit-content">
    <div class="user-profile">
        <div class="user-icon">
            <img src="{{ $user->img ? asset('storage/' . $user->img) : asset('images/default-user.png') }}" alt="ユーザー画像" class="user-icon-img">
        </div>
        <div class="user-profile__name">
            <h2 class="user-name">{{ $user->name }}</h2>
        </div>
        <div class="user-profile__link">
            <a class="profile-edit-link" href="{{ route('profile.edit') }}">プロフィールを編集</a>
        </div>
    </div>

    <div class="mypage__tab-buttons">
        <button id="sellBtn" onclick="showTab('sell')" class="tab-buttons">出品した商品</button>
        <button id="buyBtn" onclick="showTab('buy')" class="tab-buttons">購入した商品</button>
    </div>

    <div id="itemList"></div>

    <div id="sell" class="mypage__item-content">
        <!-- 出品した商品 -->
        @forelse ($sellingItems as $item)
            <div class="item-card">
                <div class="mypage-item-img">
                    <a href="{{ route('items.show', $item->id) }}">
                        <img
                            src="{{ $item->img_url ? $item->img_url : asset('storage/' . $item->image_path) }}"
                            alt="商品画像"
                            class="item-img">
                    </a>
                </div>
                <div class="mypage__item-name">
                    <a href="{{ route('items.show', $item->id) }}" class="item-name__a">
                        <h2 class="update-form__item-name">{{ $item->name }}</h2>
                    </a>
                </div>
            </div>
        @empty
            <p>出品した商品はありません。</p>
        @endforelse
    </div>

    <div id="buy" class="mypage__item-content">
        <!-- 購入した商品 -->
        @forelse ($purchasedItems as $item)
            <div class="item-card">
                <div class="mypage__item-img">
                    <a href="{{ route('items.show', $item->id) }}">
                        <img
                            src="{{ $item->img_url ? $item->img_url : asset('storage/' . $item->image_path) }}"
                            alt="商品画像"
                            class="item-img">
                    </a>
                </div>
                <div class="mypage__item-name">
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
        const sell = document.getElementById('sell');
        const buy = document.getElementById('buy');
        const sellBtn = document.getElementById('sellBtn');
        const buyBtn = document.getElementById('buyBtn');

        sell.classList.remove('active');
        buy.classList.remove('active');
        sellBtn.classList.remove('active');
        buyBtn.classList.remove('active');

        if (type === 'sell') {
            sell.classList.add('active');
            sellBtn.classList.add('active');
        } else {
            buy.classList.add('active');
            buyBtn.classList.add('active');
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        showTab('sell');
    });
</script>

@endsection