<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="{{ mix('js/app.js') }}" defer></script>
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <style>
    body {
      background-image: url('{{url("images/web.png")}}');
      background-size: cover;
      background-attachment: fixed;
      background-repeat: no-repeat;
    }
  </style>
</head>

<body>
  @include('navigation-menu')
  <div style="display: flex;width:100%;justify-content:center">
    <div class="card mb-3" style="width:90%;margin-top:30px">
      <div class="card-body">
        <h1 style="font-weight: bold;">Notifications</h1>
        <hr>

        <table class="table">
          <thead class="thread-light">
          </thead>
          <tbody>
            @foreach($notifications as $notification)
            @if(($notification->satate=='reserv-state' || $notification->satate=='reserv-ref') && $user==$notification->user_id && $notification->date<=$now)
            <tr>
              <td>{{$notification->room_name}}</td>
              <td>{{$notification->date}}</td>
              <td>{{$notification->creneaude}} - {{$notification->creneaua}}</td>
              <td>{{$notification->message}}</td>
            </tr>
            @endif
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>