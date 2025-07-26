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

  // インデックスページの初期タブ設定
  if (isIndex && tabButtons.length && tabContents.length) {
    tabButtons[0].classList.add('active');
    tabContents[0].style.display = 'block';
    itemList.style.display = 'none';

    tabButtons.forEach(button => {
      button.addEventListener('click', function() {
        tabButtons.forEach(btn => btn.classList.remove('active'));
        this.classList.add('active');

        const target = this.getAttribute('data-target');
        tabContents.forEach(content => {
          content.style.display = (content.id === target) ? 'block' : 'none';
        });

        itemList.style.display = 'none';
        if (searchInput) searchInput.value = '';
      });
    });
  }
  // 共通の検索処理
  if (searchInput) {
    searchInput.addEventListener('input', function () {
      const keyword = this.value.trim();

      if (!keyword) {
        itemList.style.display = 'none';

        if (isIndex) {
          tabContents.forEach(tab => tab.style.display = 'none');
          const activeTab = document.querySelector('.tab-button.active');
          if (activeTab) {
            const targetId = activeTab.getAttribute('data-target');
            const targetEl = document.getElementById(targetId);
            if (targetEl) targetEl.style.display = 'block';
          }
        } else if (isMypage && sell && buy) {
          sell.style.display = 'block';
          buy.style.display = 'none';
        }

        return;
      }

      itemList.innerHTML = '<p>検索中...</p>';
      itemList.style.display = 'block';

      fetch(`/api/search?keyword=${encodeURIComponent(keyword)}`)
        .then(res => res.json())
        .then(data => {
          if (!data.length) {
            itemList.innerHTML = '<p>該当する商品がありません。</p>';
            return;
          }

          const html = data.map(item => {
            const img = item.image_url || item.img_url || '/images/noimage.png';
            const name = item.name;
            const link = `/items/${item.id}`;

            if (isMypage) {
              return `
                  <div class="item-card">
                    <div class="mypage-item-img">
                      <a href="${link}">
                        <img src="${img}" alt="${name}" class="item-img" />
                      </a>
                    </div>
                    <div class="mypage__item-name">
                      <a href="${link}" class="item-name__a">
                        <h2 class="update-form__item-name">${name}</h2>
                      </a>
                    </div>
                  </div>
              `;
            }

            // index用
            return `
              <div class="item-card">
                <div class="index__item-img">
                  <a href="${link}">
                    <img src="${img}" alt="${name}" class="item-img" />
                  </a>
                </div>
                <div class="index__item-name">
                  <a href="${link}" class="item-name__a">
                    <h2 class="update-form__item-name">${name}</h2>
                  </a>
                </div>
              </div>
            `;
          }).join('');

          itemList.innerHTML = `<div class="search-results">${html}</div>`;

          // 検索時は他コンテンツを非表示
          if (isIndex) {
            tabContents.forEach(tab => tab.style.display = 'none');
          } else if (isMypage && sell && buy) {
            sell.style.display = 'none';
            buy.style.display = 'none';
          }
        })
        .catch(() => {
          itemList.innerHTML = '<p>検索中にエラーが発生しました。</p>';
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
