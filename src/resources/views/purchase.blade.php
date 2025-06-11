@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="container mt-5">
  <h2>購入確認</h2>

  <div class="row mt-4">
    <div class="col-md-6 text-center">
      <img src="{{ $item->img_url }}" alt="{{ $item->name }}" class="img-fluid" style="max-height: 300px;">
    </div>
    <div class="col-md-6">
      <h3>{{ $item->name }}</h3>
      <p>価格: <strong>￥{{ number_format($item->price) }}</strong></p>
      <p>{{ $item->description }}</p>

      <form action="#" method="POST">
        @csrf
        {{-- 購入確定処理は未実装なので仮のボタン --}}
        <button type="submit" class="btn btn-success mt-3">購入を確定する</button>
      </form>
    </div>
  </div>
</div>
@endsection