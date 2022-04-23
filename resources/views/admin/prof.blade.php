<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Professors</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script src="{{ mix('js/app.js') }}" defer></script>
  <style>
    body {
      background-image: url('{{url("images/web.png")}}');
      background-size: 100% 104%;
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
  <div>
    @include('admin.navigation-menu')
    <div style="display: flex;width:100%;justify-content:center">
      <div class="card mb-3" style="width:90%;margin-top:30px">
        @if(session()->has('message'))
        <div id="hh" class="alert alert-danger">
          {{session()->get('message')}}
        </div>
        @endif

        <div class="card-body">
        <div style="display: flex;justify-content: space-between;width:94%">
            <h1 style="font-weight: bold;">Professors List</h1>
            <a href="{{ route('register') }}" class="btn btn-sm btn-warning" style="width:120px;background:#a2c0da;box-shadow: 0px 2px 4px gray;border-radius:15px;color:white;border:none ;">Add </a>
          </div>
          <table class="table">
            <thead class="thread-light">
              <tr>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Operations</th>
              </tr>
            </thead>
            <tbody>
              @foreach($profs as $prof)
              @if( $prof->role=='prof')
              <div id="overlay">
              <div style="display:flex; flex-direction:column;justify-content:center;align-items:center;width:30%;height:40%;gap: 17px;background:white;border-radius:20px;box-shadow: 10px 10px 20px rgba(0,0,0,0.5);">
                  <p><strong>Are you sure to delete this Professor ?</strong></p>
                  <img src="{{url('images/deleted.png')}}" style="width:40%;height:40%" alt="">
                  <div style="display:flex;flex-direction:row;justify-content:center; gap:20px">
                    <a href="{{ url('/destroyy/'.$prof->id) }}" class="btn btn-sm btn-warning" style="background: rgb(224, 54, 54);color:white;border:none;box-shadow: 0px 2px 4px gray;border-radius:15px;">Delete</a>
                    <a href="" onclick="document.getElementById('overlay').style.display='none';" class="btn btn-sm btn-warning" style="background: lightgray;border:none;box-shadow: 0px 2px 4px gray;border-radius:15px;">Cancel</a>
                  </div>
                </div>
              </div>
              <tr>
                <td>{{ $prof->name }}</td>
                <td>{{ $prof->email }}</td>
                <td>
                  <button onclick="document.getElementById('overlay').style.display='flex'" class="btn btn-sm btn-warning " style="background-color: #f9a35c;color:white;border:none;box-shadow: 0px 2px 4px gray;border-radius:15px;padding:3.7px 18px">Delete</button>
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