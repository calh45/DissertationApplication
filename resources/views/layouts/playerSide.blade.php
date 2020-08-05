<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/playerHome.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/playerHome') }}">
                <b>NGT</b>
            </a>

            <div class="playerNavOption">
                <a class="topLinks" href="{{ route("calendar", ["year" => 2020]) }}">
                    Calendar
                </a>
            </div>

            <div class="playerNavOption">
                <a class="topLinks" href="{{ route("playerFees",["id" => Auth::user()->id]) }}">Fees</a>
            </div>

            <div class="playerNavOption">
                <a class="topLinks" href="{{ route("allPlayers", ["toOrder" => "goals"]) }}">Squad</a>
            </div>

            <div class="playerNavOption">
                <a class="topLinks" href="{{ route("allTargets") }}">Targets</a>
            </div>


            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->


                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">

                    @if(count(\Illuminate\Support\Facades\Auth::user()->notifications->where('seen', 0)) > 0)
                        <p style="color: red"> ( {{ count(\Illuminate\Support\Facades\Auth::user()->notifications->where('seen', 0)) }} ) </p>
                    @endif
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route("notifications") }}">
                                    Notifications
                                    @if(count(\Illuminate\Support\Facades\Auth::user()->notifications->where('seen', 0)) > 0)
                                        <b style="color: red; font-size: 10px;"> ( {{ count(\Illuminate\Support\Facades\Auth::user()->notifications->where('seen', 0)) }} ) </b>
                                    @endif
                                </a>

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

    <main>
        @yield('content')
    </main>
</div>
</body>
</html>
