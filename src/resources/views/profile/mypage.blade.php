@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsectionmy

@section('content')

<div class="edit-content">

    <div class="user">
        @foreach($item->comments->sortByDesc('created_at') as $comment)
        <span class="user-icon">　 </span>
        <span class="user-name">{{ $comment->user->name }}</span>
        @endforeach
    </div>

    <div class="edit-link">
        <a class="header__nav-a" href="{{ route('profile.edit') }}">プロフィールを編集</a>
    </div>














</div>

@endsection
