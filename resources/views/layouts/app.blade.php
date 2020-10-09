<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/layout.css') }}" rel="stylesheet">
    <link href="{{ asset('css/top.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body style="min-height: 100%; display: flex; flex-direction: column;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light shadow-sm" style="background-color: #FFCCCC">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}" style="font-size: 20px; font-weight: bold;">
                    {{ config('app.name', 'Laravel') }}
                    <img src="{{ asset('images/book_icon.png') }}" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('read') }}" class='nav-link'>積読解消ページ</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('create') }}" class='nav-link'>積読を登録する</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('show') }}" class='nav-link'>積読金額を確認</a>
                            </li>

                        @endauth
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('ユーザー登録') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="wrapper" style="display: flex; flex-direction: column; min-height: 80vh;">
            @yield('content')
        </main>

        <footer class="footer_design text-center" style="bottom: 0; height: 160px; background: #FFCCCC; postion: absolute; margin: auto;">
            <div style="">
                さぁ積読を登録しよう!!<br>
                <p style="font-size:2.5em; margin: 0;">Tsundokumgmt.</p><br>
                <p style="font-size:0.7em; margin: 0;">@copyright Tsundokumgmt.</p>
            </div>
        </footer>
    </div>
</body>
</html>
