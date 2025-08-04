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

<body class="@yield('body_class')">
  <header class="header">
    <div class="header__inner">
      <div class="header__logo">
        <a class="header__logo-a" href="{{ route('index') }}">
          <img src="{{ asset('storage/images/logo.svg') }}" alt="ロゴ" class="header__logo-img"/>
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
              <a class="header__nav-a" href="{{ route('profile.mypage') }}">マイページ</a>
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
document.addEventListener('DOMContentLoaded', function() {
  const searchInput = document.getElementById('searchInput');
  const itemList = document.getElementById('itemList');
  const body = document.body;

  const isIndex = body.classList.contains('page-index');
  const isMypage = body.classList.contains('page-mypage');

  const tabButtons = document.querySelectorAll('.tab-button');
  const tabContents = document.querySelectorAll('.tab-content');
  const sell = document.getElementById('sell');
  const buy = document.getElementById('buy');

  if (isIndex && tabButtons.length && tabContents.length) {
    tabButtons[0].classList.add('active');
    tabContents[0].style.display = 'block';
    itemList.style.display = 'none';

    tabButtons.forEach(button => {
      button.addEventListener('click', function () {
        tabButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        const target = this.getAttribute('data-target');
        tabContents.forEach(content => {
          content.style.display = (content.id === target) ? 'block' : 'none';
        });

        // 検索キーワードによる再フィルタ
        const keyword = searchInput.value.trim().toLowerCase();
        tabContents.forEach(tab => {
          const cards = tab.querySelectorAll('.item-card');
          cards.forEach(card => {
            const nameEl = card.querySelector('.update-form__item-name');
            const name = nameEl ? nameEl.textContent.toLowerCase() : '';
            card.style.display = keyword && !name.includes(keyword) ? 'none' : 'block';
          });
        });

        itemList.style.display = 'none';
      });
    });
  }

  if (searchInput) {
    searchInput.addEventListener('input', function () {
      const keyword = this.value.trim().toLowerCase();

      if (!keyword) {
        tabContents.forEach(tab => {
          const cards = tab.querySelectorAll('.item-card');
          cards.forEach(card => card.style.display = 'block');
        });
        itemList.style.display = 'none';
        return;
      }

      itemList.style.display = 'none';

      tabContents.forEach(tab => {
        const cards = tab.querySelectorAll('.item-card');
        cards.forEach(card => {
          const nameEl = card.querySelector('.update-form__item-name');
          const name = nameEl ? nameEl.textContent.toLowerCase() : '';
          card.style.display = name.includes(keyword) ? 'block' : 'none';
        });
      });
    });
  }
});
</script>

  <main>
    @yield('content')
  </main>
  @yield('js')
</body>

</html>
