@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
  <div class="item-content">
    <div class="detail__item-img">
        <img
            src="{{ $item->image_path ? asset('storage/' . $item->image_path) : $item->img_url }}"
            alt="{{ $item->name }}"
            class="item-img"
        />
        @if ($item->is_sold)
            <div class="sold-label">SOLD</div>
        @endif
    </div>
    <div class="detail__item-text-box">
        <h2 class="item-name">{{ $item->name }}</h2>
        <p class="item-text">ブランド名</p>
        <h3 class="item-price">￥{{ number_format($item->price) }}<span class="price-tax">(税込)</span></h3>

        <div class="flex">
            <div class="like-section">
                <span class="icon-count">
                    <button id="likeButton" class="like-btn">
                        @if(Auth::check() && $item->isLikedBy(Auth::user()))
                            ❤️
                        @else
                            🤍
                        @endif
                    </button>
                </span>
                <p>{{ $item->likes->count() }} </p>
            </div>

            <div class="comment-count">
                <span class="icon-count">💬</span>
                <p>{{ $item->comments->count() }}</p>
            </div>
        </div>

        <div class="purchase">
            @if ($item->is_sold)
                <span class="purchase-btn sold-btn">SOLD</span>
            @else
                <a href="{{ route('items.purchase.show', $item->id) }}" class="purchase-btn">購入手続きへ</a>
            @endif
        </diV>
        <h4 class="item-text-title">商品説明</h4>
            <p class="item-text">{{ $item->description }}</p>
            <p class="item-text">カラー：</p>
            <p class="item-text">新品</p>
            <p class="item-text">購入後、即発送いたします。</p>
        <h4 class="item-text-title">商品の状態</h4>
        <div class="flex">
            <div class="item-category">カテゴリー</div>
            <div class="item-text-date">
                <ul class="category-ul">
                @foreach ($item->categories as $category)
                    <li class="category-li">{{ $category->name }}</li>
                @endforeach
                </ul>
            </div>
        </div>
        <div class="flex">
            <div class="item-condition">商品の状態</div>
            <div class="item-text-date">{{ $item->condition->name ?? '状態未設定' }}</div>
        </div>

            <p class="item-text">コメント({{ $item->comments->count() }})</p>

        <div class="user-comment-box">
            @foreach($item->comments->sortByDesc('created_at') as $comment)
                <div class="user">
                    <div class="user-flex">
                        @php
                            $commentUser = $comment->user;
                        @endphp

                        @if($commentUser && $commentUser->img && Storage::disk('public')->exists($commentUser->img))
                            <img src="{{ asset('storage/' . $commentUser->img) }}" alt="{{ $commentUser->name }}の画像" class="user-icon-img">
                        @else
                            <img src="{{ asset('images/default-user.png') }}" alt="デフォルト画像" class="user-icon-img">
                        @endif
                        <div class="user-name">{{ $commentUser->name }}</div>
                    </div>
                    <div class="user-comment">{{ $comment->content }}</div>
                </div>
            @endforeach
        </div>

        <div class="comment-text-box">
            <h5 class="comment-title">商品へのコメント</h5>

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
