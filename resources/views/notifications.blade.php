<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="{{ mix('js/app.js') }}" defer></script>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>

<body style="background:rgb(236, 219, 162)">
  @include('navigation-menu')

  <div style="display: flex;width:100%;justify-content:end">
  </div>
  <div class="card mb-3" style="width:90%;margin:auto">
    <div class="card-body">
      <h1>Notifications</h1>

      <table class="table">
        <thead class="thread-light">
        </thead>
        <tbody>
          @foreach($notifications as $notification)
          @if($notification->satate=='reserv-state' && $user==$notification->user_id)
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