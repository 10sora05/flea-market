<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログインページ</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('css')
</head>
<body>

    <header class="login-header">
        <div class="header__logo">
            <a class="header__logo-a" href="{{ route('index') }}">
                <img src="{{ asset('storage/images/logo.svg') }}" alt="ロゴ" />
            </a>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

</body>
</html>
