@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-container">
    <h2 class="sell-h2">商品の出品</h2>

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="image" class="sell-label">商品画像</label><br>

            <div class="sell-img">
                <label for="image" class="custom-file-label">
                    <span class="label-text">画像を選択する</span>
                </label>
                <input type="file" name="image" id="image" accept="image/*" class="custom-file-input">
            </div>

            @error('image')
                <div class="error">{{ $message }}</div>
            @enderror
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
            @error('categories')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="condition_id" class="sell-label">商品の状態</label>
            <select name="condition_id" class="form-control">
                <option value="">選択してください</option> <!-- ← これを追加 -->
                @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}"
                        {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                        {{ $condition->name }}
                    </option>
                @endforeach
            </select>
            @error('condition_id')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="name" class="sell-label">商品名</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="brand" class="sell-label">ブランド名</label>
            <input type="text" name="brand" class="form-control" value="{{ old('brand') }}">
            @error('brand')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description" class="sell-label">商品の説明</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="price" class="sell-label">販売価格</label>
            <div class="yen-input">
                <span class="yen-symbol">￥</span>
                <input type="number" name="price" class="form-control price-input" value="{{ old('price') }}" min="1" max="1000000">
            </div>
            @error('price')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn-list">出品する</button>
    </form>
</div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.querySelector('.custom-file-input');
        const fileLabel = document.querySelector('.custom-file-label');

        fileInput.addEventListener('change', function () {
            const fileName = this.files[0] ? this.files[0].name : '画像を選択する';
            fileLabel.textContent = fileName;
        });
    });
</script>
@endsection