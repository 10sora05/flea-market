@extends('layouts.app')

@section('body_class', 'page-index')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="index__header">
  <div class="index__header-li">
    <button class="tab-button" data-target="recommend">おすすめ</button>
  </div>
  <div class="index__header-li">
    <button class="tab-button" data-target="mylist">マイリスト</button>
  </div>
</div>

<div id="itemList"></div>

<div id="recommend" class="tab-content">
  @foreach ($items->chunk(4) as $chunk)
    <div class="index__item-content">
      @foreach ($chunk as $item)
        <div class="item-card">
          <div class="index__item-img">
            <a href="{{ route('items.show', $item->id) }}">
              <img src="{{ $item->image_url }}" alt="商品画像" class="item-img">
            </a>
            @if ($item->is_sold)
              <div class="sold-label">SOLD</div>
            @endif
          </div>
          <div class="index__item-name">
            <a href="{{ route('items.show', $item->id) }}" class="item-name__a">
              <h2 class="update-form__item-name">{{ $item->name }}</h2>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach
</div>

<div id="mylist" class="tab-content" style="display: none;">
  @foreach ($likedItems->chunk(4) as $chunk)
    <div class="index__item-content">
      @foreach ($chunk as $item)
        <div class="item-card">
          <div class="index__item-img">
            <a href="{{ route('items.show', $item->id) }}">
              <img
                  src="{{ $item->image_path ? asset('storage/' . $item->image_path) : $item->img_url }}"
                  alt="{{ $item->name }}"
                  class="item-img"
              />
            </a>
            @if ($item->is_sold)
              <div class="sold-label">SOLD</div>
            @endif

          </div>
          <div class="index__item-name">
            <a href="{{ route('items.show', $item->id) }}" class="item-name__a">
              <h2 class="update-form__item-name">{{ $item->name }}</h2>
            </a>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach
</div>

@endsection

@section('js')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    // 初期状態で "おすすめ" タブをアクティブにしておく
    tabButtons[0].classList.add('active');
    tabContents[0].style.display = 'block';

    tabButtons.forEach(button => {
      button.addEventListener('click', function() {
        // タブボタンの active クラスを切り替え
        tabButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        // 表示切り替え
        const target = this.getAttribute('data-target');
        tabContents.forEach(content => {
          if (content.id === target) {
            content.style.display = 'block';
          } else {
            content.style.display = 'none';
          }
        });
      });
    });
  });
</script>
@endsection
