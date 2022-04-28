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
    td {
      text-align: center;
    }

    th {
      text-align: center;
    }
  </style>
</head>

<body>
  @include('admin.navigation-menu')

  <div style="display: flex;width:100%;justify-content:center;align-items:center">
  <div class="hello">
    @if(session()->has('message'))
    <div id="hh" class="alert alert-danger">
      {{session()->get('message')}}
    </div>
    @endif
    <div class="card-body">
      <h1 style="font-weight: bold">Notifications</h1>

      <table class="table">
        <thead class="thread-light">
          <tr>
            <th scope="col">Name</th>
            <th scope="col">Room</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Operations</th>
          </tr>
        </thead>
        <tbody>
          @foreach($reservations as $reservation)
          @if($reservation->satate=='wait')
          <div id="overlay">
            <div style="display:flex; flex-direction:column;justify-content:center;align-items:center;gap:20px;width:30%;height:20%;background:white;border-radius:20px;">
              <p><strong>Are you sure to Refuse this reservation ?</strong></p>
              <div style="display:flex;flex-direction:row;justify-content:center; gap:20px">
                <a href="{{url('/refuse/'.$reservation->id)}}" onclick="document.getElementById('overlay').style.display='none';" class="btn btn-sm btn-danger" style="border:none">Refuse</a>
                <a href="" onclick="document.getElementById('overlay').style.display='none';" class="btn btn-sm btn-warning" style="background: lightgray;border:none">Cancel</a>
              </div>
            </div>
          </div>
          <tr>
            <td>name</td>
            <td>{{$reservation->room_name}}</td>
            <td>{{$reservation->date}}</td>
            <td>{{$reservation->creneaude}} - {{$reservation->creneaua}}</td>

            <td style="display: flex;gap:10px;justify-content: center;" >
              <a href="{{url('/accept/'.$reservation->id)}}"><img src="{{url('images/accept.png')}}" alt=""></a>
              <button onclick="document.getElementById('overlay').style.display='flex'"><img src="{{url('images/failed.png')}}" alt=""></button>
            </td>
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