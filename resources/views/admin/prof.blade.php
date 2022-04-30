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
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <script src=//code.jquery.com/jquery-3.5.1.slim.min.js integrity="sha256-4+XzXVhsDmqanXGHaHvgh1gMQKX40OUvDEBTu8JcmNs=" crossorigin=anonymous></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <style>
    body {
      background-image: url('{{url("images/web.png")}}');
      background-size:cover;
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
      <div class="hello">
        @if(session()->has('message'))
        <div id="hh" class="alert alert-success">
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
              <tr>
                <td>{{ $prof->name }}</td>
                <td>{{ $prof->email }}</td>
                <td>
                  <a class="delete" href="{{ url('/destroyy/'.$prof->id) }}"><img src="{{url('images/delete.png')}}" alt=""></a>
                </td>
              </tr>
              @endif
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script>
    $('.delete').on('click', function(event) {
      event.preventDefault();
      const url = $(this).attr('href');
      swal({
        title: 'Are you sure you want to delete this professor?',
        text: 'This record will be permanantly deleted!',
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