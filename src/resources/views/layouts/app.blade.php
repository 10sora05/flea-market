<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>coachtech flea-market</title>
  <link rel="stylesheet" href="{{ asset('css/reset.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header__logo">
        <a class="header__logo-a" href="{{ route('index') }}">
          <img src="{{ asset('storage/images/logo.svg') }}" alt="ロゴ" />
        </a>
      </div>
      <div class="header__search">
        <form action="/search" method="GET">
          <input type="text" name="q" placeholder="何をお探しですか？" class="header__search-input" onkeydown="if(event.key==='Enter'){ this.form.submit(); }">
        </form>
      </div>
      <div class="header__nav">
        <ul class="header__nav-ul">
          <li class="header__nav-li">
            <a class="header__nav-a" href="{{ route('index') }}">ログアウト</a>
          </li>
          <li class="header__nav-li">
            <a class="header__nav-a" href="{{ route('mypage') }}">マイページ</a>
          </li>
          <li class="header__nav-li">
            <a class="header__nav-sell" href="{{ route('sell') }}">出品</a>
          </li>
        </ul>
      </div>
    </div>

  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>
