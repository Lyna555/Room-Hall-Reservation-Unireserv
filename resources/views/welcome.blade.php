<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>unireserv</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@700&display=swap');
    </style>
    <style type="text/css">
        .translated-ltr {
            margin-top: -40px;
        }

        .translated-ltr {
            margin-top: -40px;
        }

        .goog-te-banner-frame {
            display: none;
            margin-top: -20px;
        }

        .goog-logo-link {
            display: none !important;
        }

        .goog-te-gadget {
            color: transparent !important;
        }
    </style>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Nunito', sans-serif;
            background-image: url('{{url("images/web.png")}}');
            background-size: cover;
            background-repeat: no-repeat;
        }

        #container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            gap: 30px;
        }

        #auth {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px
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
        }

        #dashb:hover {
            color: black;
            background: #f89760;
        }

        #cont {
            min-width: 40%;
            min-height: 60%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            border-radius: 20px;
        }

        img {
            width: 150px;
            height: 150px;
            margin-bottom: 30px;
        }

        select {
            width: 80px;
            border-radius: 15px;
        }
    </style>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en'
            }, 'google_translate_element');
        }
    </script>

</head>

<body class="antialiased">
    <div id="container">
        <div id="cont">
            <div style="display: flex;gap:10px">
                <p>Choose the language : </p>
                <div id="google_translate_element"></div>
            </div>
            <p style="font-family: 'Script MT';font-size: 50px;">unireserve</p>
            <h1 style="font-family:Nunito;font-size:30px; text-align:center;font-weight:150; text-shadow:3px 3px 4px black;">Join us!</h1>
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
        <stream-chat :autheduser="{{ Auth::user() }}"></stream-chat>

    </div>
</body>

</html>