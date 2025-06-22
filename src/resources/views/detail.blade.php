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
                @if(Auth::check() && $item->isLikedBy(Auth::user()))
                    ❤️
                @else
                    🤍
                @endif
            </button>
            <p>　{{ $item->likes->count() }} </p>
        </div>

        <div class="purchase">
            <a href="{{ route('items.purchase', $item->id) }}" class="purchase-btn">購入手続きへ</a>
        </diV>
        <h4 class="item-text-title">商品名</h4>
        <p class="item-text">{{ $item->description }}</p>
        <h4 class="item-text-title">商品説明</h4>
            <p class="item-text">カラー：</p>
            <p class="item-text">新品</p>
            <p class="item-text">購入後、即発送いたします。</p>
        <h5 class="item-text-title">カテゴリー</h5>
        <span class="item-text-date"> </span><br>
        <h5 class="item-text-title">商品の状態</h5>
        <span class="item-text-date">{{ $item->condition->name ?? '状態未設定' }}</span><br>
        <p class="item-text">コメント({{ $item->comments->count() }})</p>
        <div class="user-comment-box">
            <div class="user">
                @foreach($item->comments->sortByDesc('created_at') as $comment)
                <span class="user-icon">　 </span>
                <span class="user-name">{{ $comment->user->name }}</span>
            <div class="user-comment">{{ $comment->content }}</div>
                @endforeach
            </div>
        </div>

        <div class="comment-text-box">
            <h5 class="item-text">商品へのコメント</h5>

            <form action="{{ route('comment.store', $item->id) }}" method="POST" id="comment-form">
                @csrf
                <div class="form-group">
                    <input type="text" name="content" class="form-comment" placeholder="" maxlength="255">
                    @error('content')<p class="error">{{ $message }}</p>@enderror
                </div>

                {{-- ✅ ログイン判定で送信方法を分岐 --}}
                @if(Auth::check())
                    <button type="submit" class="comment-btn">送信</button>
                @else
                    <button type="button" class="comment-btn" onclick="alert('コメントするにはログインが必要です。')">送信</button>
                @endif
            </form>
        </div>
    </div>
  </div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const likeButton = document.getElementById('likeButton');
        const itemId = {{ $item->id }};
        const isLoggedIn = @json(Auth::check());
        let liked = @json(Auth::check() ? $item->isLikedBy(Auth::user()) : false);

        if (!isLoggedIn) {
            likeButton.addEventListener('click', () => {
                alert("いいね機能を使うにはログインが必要です。");
            });
            return;
        }

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
                likeButton.textContent = liked ? '❤️ ' : '🤍 ';
            });
        });
    });
</script>

@endsection
