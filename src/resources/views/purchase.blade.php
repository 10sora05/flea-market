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
      <select id="payment-method" name="payment" class="payment">
        <option value="コンビニ払い">コンビニ払い</option>
        <option value="カード支払い">カード支払い</option>
      </select>
    </div>
    <div class="user-detail">
      <h3>配送先
      <span><a href="{{ route('profile.address') }}" class="address-page-a">変更する</a></span>      </h3>
      <p class="user-info">{{ Auth::user()->post ?? '' }}</p>
      <p class="user-info">{{ Auth::user()->address ?? '住所が未登録です' }}</p>
      <p class="user-info">{{ Auth::user()->bldg ?? '' }}</p>
    </div>
  </div>
  <div class="purchase-rightbox">
    <table class="information-table">
      <tr class="information-tr">
        <th class="information-th">商品代金</th>
        <th class="information-th">￥{{ number_format($item->price) }}</th>
      </tr>
      <tr class="information-tr">
        <th class="information-th">支払方法</th>
        <th class="information-th"><span id="selected-payment">未選択</span></th>
      </tr>
    </table>
    <script>
      const paymentSelect = document.getElementById('payment-method');
      const selectedPayment = document.getElementById('selected-payment');

      paymentSelect.addEventListener('change', function() {
        selectedPayment.textContent = paymentSelect.value;
      });
    </script>
    <form action="#" method="POST">
      @csrf
            {{-- 購入確定処理は未実装なので仮のボタン --}}
      <button type="submit" class="btn-order">購入する</button>
    </form>
  </div>
</div>
@endsection