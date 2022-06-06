<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Unireserv</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
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

        option {
            color: black;
            height: 20px;
            border-radius: 20px;
        }

        .cards {
            background-image:url('{{url("images/card.jpg")}}');
            background-size: cover;
            background-repeat: no-repeat;
            box-shadow: 0px 4px 8px gray;
        }

        #google_translate_element select {
            color: black;
            border-radius: 20px;
            border-color: transparent;
            background-color: transparent;
            cursor: pointer;
            font-weight: bold;
            margin: 0;
            padding-block: 0;
            height: 23px;
        }

        .welc-cont {
            display: flex;
            flex-direction: column;
            gap: 20px;
            width: 60%;
            height: 92.9vh;
            justify-content: center;
            align-items: center;
            position: absolute
        }

        .butn {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            background-color: orange;
            border: 2px solid white;
            font-weight: bold;
            color: black;
            font-size: 16px;
            padding: 5px 30px;
            cursor: pointer;
            border-radius: 5px;
            text-align: center;
        }

        .butn:hover {
            background-color: transparent;
        }

        @media (max-width: 1044px) and (max-width: 768px) {
            .welc-cont {
                width: 100%;
            }
        }
    </style>


</head>

<body>

    <div style="display: flex;justify-content:end;align-items: center;width: 98%;gap:20px;height: 39px;">
        <div style="margin-top:15px" id="google_translate_element"></div>

        <a href="{{url('/welcomeContactus')}}" style="font-weight: bold;">Contact Us</a>

        @if (Route::has('login'))
        <div>
            @auth
            <a class="butn" href="{{ url('/redirects') }}">Dashboard</a>
            @else
            <a class="butn" href="{{ route('login') }}">Login</a>
            @endauth
        </div>
        @endif
    </div>

    <div class="welc-cont">
        <div style="display:flex;flex-direction:column;text-align:center;font-family:'Script MT Bold';font-size:90px;line-height: 80px;">
            <div class="welc">Welcome to our</div>
            <div class="welc">Unireserv</div>
        </div>
        <div style="text-align:center;font-size:15px;font-weight: bold;">Now you can book rooms and amphitheaters<br>in efficient, easy and fast way!</div>
        <a href="#more" class="btn btn-info" style="background-color: skyblue;border:none;font-weight: bold;box-shadow: 0px 3px 6px gray;">More Details</a>
    </div>
    <div style="display: flex;width:100%;height:94vh;justify-content:end;align-items:end">
        <img src="{{URL('images/hall.png')}}" alt="">
    </div>
    <br><br>
    <div id="more">
        <div style="display: flex;flex-direction: column;justify-content: center;align-items: center;">
            <br>
            <div class="about" style="max-width: 78%;backdrop-filter: blur(8px);background-color: rgba(255,255,255,0.2);font-weight: bold;color:black;padding:20px">
                <h1 class="featr">About</h1><br>
                <p style="text-indent: 30px;">Nowadays time is just a mirror reflecting our journey towards a bright future, and many people do not seem to notice how important is to do our daily chores in an organized and tidy way, especialy when it comes to students, administrators and professors who are racing with time to accomplish their educational intentions and tasks, that's why we wanted to offer the educational university family an opportunity to save time, efforts and energy, by making the professors being able to reserve rooms/halls suiting them and their students needs, depending on its type and size anytime and anywhere.
                <p>
            </div>
        </div>

        <div style="width:99%;min-height:94vh;display:flex;;justify-content:end;align-items: stretch;">
            <div class="card-cont">
                <div></div>
                <div></div>
                <div class="features">
                    <h1 class="featr">Professor Features</h1>
                </div>
                <br>
                <div class="cards" style="display:flex;justify-content:center;align-items: center;gap:20px;padding:10px">
                    <img src="{{URL('images/calendar.png')}}" alt="calendar" style="height:6em;width:6em">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Calendar</h2>Our website allows you to see all reservations in your faculty using a calendar.
                    </div>
                </div>
                <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px">
                    <img src="{{URL('images/timetable.png')}}" alt="calendar" style="height:6em;width:6em">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Reservations</h2>You can reserve a Room/Hall easily and save your time!
                    </div>
                </div>
                <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px">
                    <img src="{{URL('images/email.png')}}" alt="calendar" style="height:6em;width:6em">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Contact</h2>Contact other professors in your faculty if needed!
                    </div>
                </div>
                <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px">
                    <img src="{{URL('images/notification.png')}}" alt="calendar" style="height:6em;width:6em;padding:10px">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Notifications</h2>If you reserve a speacial room, a notification will reach you that your reservation is accepted or refused !
                    </div>
                </div>

                <div></div>
                <div></div>

                <div class="features">
                    <h1 class="featr">Admin Features</h1>
                </div>
                <br>
                <div class="cards" style="display:flex;justify-content:center;align-items: center;gap:20px;padding:10px">
                    <img src="{{URL('images/calendar.png')}}" alt="calendar" style="height:6em;width:6em">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Calendar</h2>Our website allows you to see all reservations within faculty using a calendar.
                    </div>
                </div>
                <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px">
                    <img src="{{URL('images/timetable.png')}}" alt="calendar" style="height:6em;width:6em">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Reservations</h2>You can reserve a Room/Hall easily and save your time!
                    </div>
                </div>
                <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px">
                    <img src="{{URL('images/email.png')}}" alt="calendar" style="height:6em;width:6em">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Contact</h2>Contact other professors in your faculty if needed!
                    </div>
                </div>
                <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px">
                    <img src="{{URL('images/notification.png')}}" alt="calendar" style="height:6em;width:6em;padding:10px">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Notifications</h2>Notifications of speacial Rooms/Halls reservations will reach to accept or refuse them!
                    </div>
                </div>
                <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px;margin-bottom:30px">
                    <img src="{{URL('images/room.png')}}" alt="calendar" style="height:6em;width:6em;padding:10px">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Rooms/Halls</h2>Here you can manage Rooms/Halls which your faculty contains.
                    </div>
                </div>
                <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px;margin-bottom:30px">
                    <img src="{{URL('images/manager.png')}}" alt="calendar" style="height:6em;width:6em;padding:10px">
                    <div>
                        <h2 style="font-size: 20px;font-weight: bold;">Professors</h2>You can also manage the account of faculty professors to offer a more secured system!
                    </div>
                </div>
            </div>
            <div class="up-img">
                <img onclick="document.getElementById('more').style.display='none'" src="{{url('images/up.png')}}" alt="up_arrow" style="cursor: pointer;height:3em;width:3em;">
            </div>
        </div>
    </div>
    <stream-chat :autheduser="{{ Auth::user() }}"></stream-chat>

</body>

</html>