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
        <div style="display: flex;justify-content: space-between;align-items:center;width:94%">
          <h1 style="font-weight: bold;">Rooms/Halls List</h1>
          <a calss="add-button" href="{{ route('addRoom') }}" class="btn btn-sm btn-warning" style="width:134px;background:#a2c0da;box-shadow: 0px 2px 4px gray;border-radius:15px;color:white;border:none ; ">Add</a>
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
            <div id="overlay">
              <div class="delete">
                <p><strong>Are you sure to delete this Room/Hall?</strong></p>
                <img src="{{url('images/deleted.png')}}" style="width:40%;height:40%" alt="">
                <div style="display:flex;flex-direction:row;justify-content:center; gap:20px">
                  <a href="{{ url('/destroy/'.$room->id) }}" class="btn btn-sm btn-warning" style="background: rgb(224, 54, 54);color:white;border:none;box-shadow: 0px 2px 4px gray;border-radius:15px;">Delete</a>
                  <a href="" onclick="document.getElementById('overlay').style.display='none';" class="btn btn-sm btn-warning" style="background: lightgray;border:none;box-shadow: 0px 2px 4px gray;border-radius:15px;">Cancel</a>
                </div>
              </div>
            </div>
            <tr>
              <td>{{ $room->name }}</td>
              <td>{{ $room->capacity }}</td>
              <td>{{ $room->floor }}</td>
              <td>{{ $room->type }}</td>
              <td>{{ $room->state }}</td>
              <td>
                <div style="display: flex;gap:10px;justify-content:center">
                  <button calss="button" onclick="document.getElementById('overlay').style.display='flex'"><img src="{{url('images/delete.png')}}" alt=""></button>
                  <a calss="button" href="{{ url('/edit/'.$room->id) }}"><img src="{{url('images/edit.png')}}" alt=""></a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>

</html>