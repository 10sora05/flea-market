@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="index__header">
  <div class="index__header-li"><p>おすすめ</p></div>
  <div class="index__header-li"><p>マイリスト</p></div>
</div>

<div class="index__items">
  @foreach ($items->chunk(4) as $chunk)
    <div class="item__content">
      @foreach ($chunk as $item)
        <div class="item-card">
          <div class="index__item-img">
            <a href="{{ route('items.show', $item->id) }}">
              <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="item-img">
            </a>
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