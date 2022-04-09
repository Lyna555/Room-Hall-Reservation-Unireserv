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
    @include('admin.navigation-menu')

    <div style="display: flex;width:100%;justify-content:end">
  </div>
<div class="card mb-3" style="width:90%;margin:auto">
  @if(session()->has('message'))
    <div id="hh" class="alert alert-danger">
        {{session()->get('message')}}
    </div>
  @endif
<div class="card-body">
    <h1>Rooms Halls List</h1>
    <a href="{{  }}" class="btn btn-sm btn-warning" style="background: rgb(255, 152, 67);color:white;border:none">Add</a>

    <table class="table">
      <thead class="thread-light">
        <tr>
          <th scope="col">Name</th>
          <th scope="col">Capacity</th>
          <th scope="col">Operations</th>
        </tr>
      </thead>
      <tbody>
        @foreach()
        <div id="overlay">
          <div style="display:flex; flex-direction:column;justify-content:center;align-items:center;gap:20px;width:30%;height:20%;background:white;border-radius:20px;">
            <p><strong>Are you sure to delete this Room/Hall?</strong></p>
            <div style="display:flex;flex-direction:row;justify-content:center; gap:20px">
              <a href="{{ url('/destroy/'.$room->id) }}" class="btn btn-sm btn-warning" style="background: rgb(224, 54, 54);color:white;border:none">Delete</a>
              <a href="" onclick="document.getElementById('overlay').style.display='none';" class="btn btn-sm btn-warning" style="background: lightgray;border:none">Cancel</a>
          </div>
        </div>
        </div>
        <tr>
            <td></td>
            <td></td>
            
            <td>
              <button onclick="document.getElementById('overlay').style.display='flex'" class="btn btn-sm btn-warning">Accept</button>
              <a href="{{  }}" class="btn btn-sm btn-warning">Refuse</a>
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