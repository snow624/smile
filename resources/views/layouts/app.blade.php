<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', '商品管理')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- CSRF と jQuery（先に読み込む） --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    {{-- プロジェクトの共通JS（jQuery依存があるなら defer は付けない方が安全） --}}
    <script>
        // LaravelのルートをJavaScript変数に渡す
        window.routes = {
            searchProducts: "{{ route('products.search') }}",
            deleteProduct: "{{ route('products.destroy', ['product' => ':id']) }}", // :id を置換用
        };
    </script>
    <script src="{{ asset('js/script.js') }}" defer></script>

</head>

<body>
    <div class="container">
        <header class="site-header">
            <h1 class="site-title">@yield('heading', '管理画面')</h1>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-secondary">ログアウト</button>
                </form>
            @endauth
        </header>

        @yield('content')
    </div>
    {{-- jQuery --}}
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    @stack('scripts')


</body>

</html>
