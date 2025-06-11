@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
  <div class="item-content">
    <div class="item-img">
        <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="img-fluid">
    </div>
        <div class="item-detail">
        <h2 class="item-name">{{ $item->name }}</h2>
        <p class="item-text">ブランド名</p>
        <h3 class="item-price">￥{{ number_format($item->price) }}<span class="price-tax">(税込)</span></h3>
        <div class="purchase">
            <a href="{{ route('items.purchase', $item->id) }}" class="purchase-btn">購入手続きへ</a>
        </diV>
        <h4 class="item-text-title">商品名</h4>
        <p class="item-text">{{ $item->description }}</p>
        <h4 class="item-text-title">商品の情報</h4>
        <h5 class="item-text">カテゴリー</h5>
        <h5 class="item-text">商品の状態</h5>
        <p class="item-text">コメント(1)</p>
        <div class="frex">
            <div class="user-icon">　</div>
            <div class="user-name"><p class="item-text">adomin</p></div>
        </div>
        <div class="user-text">こちらにコメントが入ります。</div>
        <h5 class="item-text">商品へのコメント</h5>
        <form>
            <div class="form-group">
                <input type="text" name="comment" class="form-comment" placeholder="">
            </div>
            <button type="button" class="comment-btn">送信</button>
        </form>
    </div>
  </div>
@endsection
