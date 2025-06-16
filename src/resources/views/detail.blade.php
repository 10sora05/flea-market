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

        <div class="like-section">
            <button id="likeButton" class="like-btn">
                @if($item->isLikedBy(Auth::user()))
                ❤️ いいね済み
                @else
                🤍 いいね
                @endif
            </button>
            <p>{{ $item->likes->count() }} 件のいいね</p>
        </div>

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

  <script>
    document.addEventListener('DOMContentLoaded', () => {
    const likeButton = document.getElementById('likeButton');
    const itemId = {{ $item->id }};
    let liked = @json($item->isLikedBy(Auth::user()));

    likeButton.addEventListener('click', () => {
        const url = `/items/${itemId}/like`;
        const method = liked ? 'DELETE' : 'POST';

        fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        },
        })
        .then(res => res.json())
        .then(data => {
        liked = data.liked;
        likeButton.textContent = liked ? '❤️ いいね済み' : '🤍 いいね';
        });
    });
    });
</script>

@endsection
