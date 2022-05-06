<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Rooms/Halls</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script src="{{ mix('js/app.js') }}" defer></script>
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <script src=//code.jquery.com/jquery-3.5.1.slim.min.js integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin=anonymous></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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
      <div id="hh" class="alert alert-success">
        {{session()->get('message')}}
      </div>
      @endif

      <div class="card-body">
        <div style="display: flex;justify-content: space-between;align-items:center;align-items: center;width:90%">
          <h1 style="font-weight: bold;">Rooms/Halls List</h1>
          <form style="display: flex;align-items: center;gap:10px" action="{{url('/searchRoom')}}" method="get">
            <button style="background-color: transparent;"><img src="{{url('images/search.png')}}" alt=""></button>
            <input name="cherche" style="border:2px solid #C3B1E1;border-radius: 20px;height: 30px;width:70%" placeholder="Search.." type="search">
          </form>
          <a calss="add-button" href="{{ route('addRoom') }}"><img style="max-width:40px;max-height:40px ;" src="{{url('images/plus.png')}}" alt=""></a>
        </div>
        <table class="table">
          <thead class="thread-light">
            <tr>
              <th scope="col">Name</th>
              <th scope="col">Capacity</th>
              <th scope="col">Floor</th>
              <th scope="col">Type</th>
              <th scope="col">State</th>
              <th scope="col">Operations</th>
            </tr>
          </thead>

          <tbody>
            @foreach($rooms as $room)
            <tr>
              <td>{{ $room->name }}</td>
              <td>{{ $room->capacity }}</td>
              <td>{{ $room->floor }}</td>
              <td>{{ $room->type }}</td>
              <td>{{ $room->state }}</td>
              <td>
                <div style="display: flex;gap:10px;justify-content:center;align-items: center;">
                  @php
                  $i=0;
                  foreach($reservations as $reservation){
                  if($reservation->room_name==$room->name){
                  $i++;
                  }
                  }
                  @endphp
                  @if($i>0)
                  <a href="{{ url('/destroy/'.$room->id) }}" class="delete1"><img src="{{url('images/delete.png')}}" alt=""></a>
                  @else
                  <a href="{{ url('/destroy/'.$room->id) }}" class="delete2"><img src="{{url('images/delete.png')}}" alt=""></a>
                  @endif
                  <a href="{{ url('/edit/'.$room->id) }}"><img src="{{url('images/edit.png')}}" alt=""></a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
      </div>
    </div>
    <script>
      $('.delete1').on('click', function(event) {
        event.preventDefault();
        const url = $(this).attr('href');
        swal({
          title: 'this room is reserved, are you sure to delete it?',
          text: 'This record and it`s details will be permanantly deleted!',
          icon: 'warning',
          buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
          if (value) {
            window.location.href = url;
          }
        });
      });

      $('.delete2').on('click', function(event) {
        event.preventDefault();
        const url = $(this).attr('href');
        swal({
          title: 'Are you sure to delete this room?',
          text: 'This record and it`s details will be permanantly deleted!',
          icon: 'warning',
          buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
          if (value) {
            window.location.href = url;
          }
        });
      });
    </script>
</body>

</html>