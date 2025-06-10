<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>coachtech flea-market</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__inner">
      <div class="header__logo">
        <a class="header__logo" href="{{ route('index') }}">
          <img src="{{ asset('storage/images/logo.svg') }}" alt="ロゴ" />
        </a>
      </div>
      <div class="header__search">
        <form action="/search" method="GET">
          <input type="text" name="q" placeholder="何をお探しですか？" class="header__search-input" onkeydown="if(event.key==='Enter'){ this.form.submit(); }">
        </form>
    </div>
    </div>

  </header>

  <main>
    @yield('content')
  </main>
</body>

</html>
