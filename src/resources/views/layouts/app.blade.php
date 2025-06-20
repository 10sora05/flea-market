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
          <input type="text" id="searchInput" placeholder="何をお探しですか？" class="header__search-input" onkeydown="if(event.key==='Enter'){ this.form.submit(); }">
        </form>
      </div>
      <div class="header__nav">
        <ul class="header__nav-ul">
          @auth
            <!-- ログイン中 -->
            <li class="header__nav-li">
              <a class="header__nav-a" href="{{ route('mypage') }}">マイページ</a>
            </li>
            <li class="header__nav-li">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="header__nav-a" style="background: none; border: none; padding: 0;">ログアウト</button>
              </form>
            </li>
          @else
            <!-- 未ログイン -->
            <li class="header__nav-li">
              <a class="header__nav-a" href="{{ route('login') }}">ログイン</a>
            </li>
            <li class="header__nav-li">
              <a class="header__nav-a" href="{{ route('register') }}">会員登録</a>
            </li>
          @endauth
            <li class="header__nav-li">
              <a class="header__nav-sell" href="{{ route('sell') }}">出品</a>
            </li>

        </ul>
      </div>
    </div>
  </header>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const searchInput = document.getElementById('searchInput');
      if (!searchInput) return;

      searchInput.addEventListener('input', function () {
        const keyword = this.value;

        fetch(`/api/search?keyword=${encodeURIComponent(keyword)}`)
          .then(response => response.json())
          .then(data => {
            const itemList = document.getElementById('itemList');
            if (!itemList) return;

            itemList.innerHTML = '';

            if (data.length === 0) {
              itemList.innerHTML = '<p>該当する商品がありません。</p>';
              return;
            }

            data.forEach(item => {
              const div = document.createElement('div');
              div.className = 'item';
              div.innerHTML = `
                <h2>${item.name}</h2>
                <p>${item.price}円</p>
              `;
              itemList.appendChild(div);
            });
          });
      });
    });
  </script>

  <main>
    @yield('content')
  </main>
</body>

</html>
