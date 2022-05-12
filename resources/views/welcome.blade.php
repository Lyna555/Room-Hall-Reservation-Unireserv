<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Unireserv</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap');
    </style>

    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>
    <style>
        body {
            background-image: url('{{url("images/web.png")}}');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .buttons {
            width: 180px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            font-family: Goudy Old Style;
            font-size: 20px;
            font-weight: bold;
            box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.493);
        }

        #login {
            color: white;
            background: #f89746;
            margin-top: 30px;
            text-decoration: none;
        }

        #login:hover {
            color: black;
            background: #f89760;
        }

        #dashb {
            color: white;
            background: #f89746;
            margin-top: 30px;
            text-decoration: none;
        }

        #dashb:hover {
            color: black;
            background: #f89760;
        }

        select,
        option {
            color: black;
            height: 20px;
            border-radius: 20px;
        }
    </style>


</head>

<body>
    <div class="welc-cont">
        <div id="lang" style="display: flex;justify-content: center;gap:10px">
            <p>Choose the language : </p>
            <div id="google_translate_element"></div>
        </div>
        <div style="display:flex;flex-direction:column;text-align:center;font-family:'Script MT';font-size:90px;line-height: 80px;">
            <div class="welc">Welcome to our</div>
            <div class="welc">unireserv</div>
        </div>
        @if (Route::has('login'))
        <div id="auth">
            @auth
            <a class="buttons" id="dashb" href="{{ url('/redirects') }}">Dashboard</a>
            @else
            <a class="buttons" id="login" href="{{ route('login') }}">Login</a>
            @endauth
        </div>
        @endif
    </div>
    <div style="display: flex;width:100%;height:100vh;justify-content:end;align-items:end">
        <img src="{{URL('images/hall.png')}}" alt="">
    </div>
    <stream-chat :autheduser="{{ Auth::user() }}"></stream-chat>

</body>

</html>