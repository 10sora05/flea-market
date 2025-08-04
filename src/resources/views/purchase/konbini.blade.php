@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-content">
  <div class="purchase-leftbox">
    <h2>コンビニ支払い情報</h2>
    <p>商品名：<strong>{{ $item->name }}</strong></p>
    <p>金額：<strong>￥{{ number_format($item->price) }}</strong></p>

    @php
      $details = $paymentIntent->next_action->konbini_display_details;
      $expires = \Carbon\Carbon::createFromTimestamp($details->expires_at)->format('Y年m月d日 H:i');
    @endphp

    <p>支払い期限：<strong>{{ $expires }}</strong></p>

    <p>
      コンビニ支払い票：<br>
      <a href="{{ $details->hosted_voucher_url }}" target="_blank" style="color: blue; text-decoration: underline;">
        支払い情報を見る（別タブで開く）
      </a>
    </p>

    <p style="margin-top: 20px; font-size: 0.9em; color: #555;">
      ※お支払い完了後、確認に数分かかる場合があります。<br>
      ※支払い後にマイページや通知で購入完了が表示されます。
    </p>
  </div>
</div>
@endsection
