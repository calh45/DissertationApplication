<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>NGT</title>

        <script src={{ asset('js/welcome.js') }}></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
                margin-bottom: 3pc;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .pictureHolder {
                width: 100%;
                height: 100%;
            }

            .imageText {
                position: absolute;
                margin-left: auto;
                margin-right: auto;
                display: block;
                width: 100%;
                height: 100%;
                background-image: linear-gradient(rgba(0,0,0,1),rgba(0,0,0,0));
                align-content: center;
                text-align: center;
                top: 3pc;
            }

            .logoText {
                position: absolute;
                text-align: center;
                width: 100%;
                top: 27%;
                font-size: 60px;
            }

            .subText {
                position: absolute;
                text-align: center;
                width: 100%;
                top: 45%;
                font-size: 30px;
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

        </div>

        <img id="changePanel" class="pictureHolder" src=images/homePage/1.png">
        <div class="imageText">
            <div class="logoText">
                <p style="color: ghostwhite"><b>Next-Gen Tracking</b></p>
                <p class="subText" style="color: ghostwhite"><b>The future of grassroots football</b></p>
            </div>
        </div>

    </body>
</html>
