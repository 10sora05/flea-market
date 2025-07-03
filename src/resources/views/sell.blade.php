@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-container">
    <h2 class="sell-h2">商品の出品</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="image" class="sell-label">商品画像</label><br>

            <div class="sell-img">
                <label for="image" class="custom-file-label">画像を選択する</label>
                <input type="file" name="image" id="image" accept="image/*" class="custom-file-input">
            </div>
        </div>

        <div class="form-group">
            <label for="categories" class="sell-label">カテゴリー</label><br/>
            @php
                $categories = ['fashion' => 'ファッション', 'electronics' => '家電', 'interior' => 'インテリア', 'woman' => 'レディース', 'men' => 'メンズ', 'cosmetics' => 'コスメ', 'book' => '本', 'game' => 'ゲーム', 'sports' => 'スポーツ', 'kitchen' => 'キッチン', 'handmade' => 'ハンドメイド', 'accessories' => 'アクセサリー', 'toys' => 'おもちゃ', 'baby-kids' => 'ベビー・キッズ'];
            @endphp

            @foreach ($categories as $value => $label)
                <div class="category-option">
                    <input type="checkbox" name="categories[]" id="cat_{{ $value }}" value="{{ $value }}"
                        {{ is_array(old('categories')) && in_array($value, old('categories')) ? 'checked' : '' }}>
                    <label for="cat_{{ $value }}">{{ $label }}</label>
                </div>
            @endforeach
        </div>

        <div class="form-group">
            <label for="condition" class="sell-label">商品の状態</label>
            <select name="condition" class="form-control">
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
        </div>

        <div class="form-group">
            <label for="name" class="sell-label">商品名</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        </div>

        <div class="form-group">
            <label for="brand" class="sell-label">ブランド名</label>
            <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
        </div>

        <div class="form-group">
            <label for="description" class="sell-label">商品の説明</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="price" class="sell-label">販売価格</label>
            <div class="yen-input">
                <span class="yen-symbol">￥</span>
                <input type="number" name="price" class="form-control price-input" value="{{ old('price') }}" min="1" max="1000000">
            </div>
        </div>

        <button type="submit" class="btn-primary">出品する</button>
    </form>
</div>
@endsection