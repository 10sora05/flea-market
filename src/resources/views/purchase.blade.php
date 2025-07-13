@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-content">

  <div class="purchase-leftbox">
    <div class="flex">
      <div class="purchase-img">
        <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="item-img">
      </div>
      <div class="item-detail">
        <h3>{{ $item->name }}</h3>
        <p>価格: <strong>￥{{ number_format($item->price) }}</strong></p>
      </div>
    </div>
    <div class="user-detail">
      <h3>支払方法</h3>

    </div>
    <div class="user-detail">
      <h3>配送先</h3>

    </div>
  </div>
  <div class="purchase-rightbox">
    <table class="information-table">
      <tr class="information-tr">
        <th class="information-th">商品代金</th>
        <th class="information-th">　</th>
      </tr>
      <tr class="information-tr">
        <th class="information-th">支払方法</th>
        <th class="information-th">　</th>
      </tr>
    </table>
    <form action="#" method="POST">
      @csrf
      {{-- 購入確定処理は未実装なので仮のボタン --}}
      <button type="submit" class="btn-order">購入する</button>
    </form>
  </div>
</div>
@endsection