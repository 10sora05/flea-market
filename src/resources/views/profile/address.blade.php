@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('content')

<div class="address-content">
    <h2 class="address-h2">住所変更</h2>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="user-information">
            <label for="post" class="user-title">郵便番号</label>
            <input type="text" name="post" class="user-input" value="{{ old('post', $user->post ?? '') }}"/>
            @error('post') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="user-information">
            <label for="address" class="user-title">住所</label>
            <input id="address" type="text" name="address" class="user-input" value="{{ old('address', $user->address ?? '') }}">
            @error('address') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="user-information">
            <label for="bldg" class="user-title">建物名</label>
            <input id="bldg" type="text" name="bldg" class="user-input" value="{{ old('bldg', $user->bldg ?? '') }}">
            @error('bldg') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="user-information">
            <button type="submit" class="address-form-button">
                更新する
            </button>
        </div>
    </form>
</div>
@endsection