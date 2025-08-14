<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', '商品管理')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/script.js') }}" defer></script>
</head>

<body>
  <div class="container">
    <header class="site-header">
      <h1 class="site-title">@yield('heading', '管理画面')</h1>

      {{-- ログアウト（POST） --}}
      @auth
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn btn-secondary">ログアウト</button>
        </form>
      @endauth
    </header>

    @yield('content')
  </div>
</body>

</html>
