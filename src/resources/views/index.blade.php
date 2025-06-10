@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')

<div class="item__content">
  <img src="{{ asset('images/index.png') }}" alt="coachtech flea-market" />
  <p>商品名</p>
</div>
@endsection
