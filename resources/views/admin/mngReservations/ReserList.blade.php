<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Reservations</title>
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

      @if(session()->has('errorMessage'))
      <div id="hh" class="alert alert-danger">
        {{session()->get('errorMessage')}}
      </div>
      @endif

      <div class="card-body">
        <div style="display: flex;justify-content: space-between;align-items: center;width:93.7%">
          <h1 style="font-weight: bold;">Reservations List</h1>
          <form style="display: flex;align-items: center;gap:10px" action="{{url('/admin/searchReser')}}" method="get">
          <button style="background-color: transparent;"><img src="{{url('images/search.png')}}" alt=""></button>
            <input name="cherche" style="border:2px solid #C3B1E1;border-radius: 20px;height: 30px;width:70%;" placeholder="Search.." type="search">
          </form>
          <a id="add" href="{{ url('/admin/showNames') }}"><img style="max-width:40px;max-height:40px ;" src="{{url('images/plus.png')}}" alt=""></a>
        </div>
        <table class="table">
          <thead class="thread-light">
            <tr>
              <th scope="col">Proprietor</th>
              <th scope="col">Room</th>
              <th scope="col">Date</th>
              <th scope="col">Entery-Time</th>
              <th scope="col">Exit-Time</th>
              <th scope="col">Objective</th>
              <th scope="col">Operations</th>
            </tr>
          </thead>
          <tbody>
            @foreach($reservations as $reservation)
            @if($reservation->date>=$sysdate && $reservation->satate!='wait' && $reservation->satate!='not-reserved' && $reservation->satate!='reserv-ref')
            <tr>
              @if($auth==$reservation->user_id)
                <td style="background-color: rgba(255,127,6,0.5);">Yours</td>
                @else
                  @foreach($users as $user)
                    @if($user->id==$reservation->user_id)
                    <td>{{$user->name}}</td>
                    @endif
                  @endforeach
              @endif
              <td>{{ $reservation->room_name }}</td>
              <td>{{ $reservation->date }}</td>
              <td>{{ $reservation->creneaude }}</td>
              <td>{{ $reservation->creneaua }}</td>
              <td>{{ $reservation->objective }}</td>
              <td>
                <div style="display: flex;gap:10px;justify-content:center;align-items: center;">
                  <a class="delete" href="{{ url('/destroyR/'.$reservation->id) }}"><img src="{{url('images/delete.png')}}" alt=""></a>
                  <a class="edited" href="{{ url('/admin/editR/'.$reservation->id) }}"><img src="{{url('images/edit.png')}}" alt=""></a>
                </div>
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
        title: 'Are you sure to delete this reservation?',
        text: 'This record will be permanantly deleted!',
        icon: 'warning',
        buttons: ["Cancel", "Yes!"],
      }).then(function(value) {
        if (value) {
          window.location.href = url;
        }
      });
    });

    $(document).ready(function() {
        fetch();

        function fetch(query = '') {
          $.ajax({
            url: "{{route('/admin/searchReser')}}",
            method: 'GET',
            data: {
              query: query
            },
            dataType: 'json',
            success: function(data) {
              $('tbody').html(data.table_data);
            }
          })
        }

        $(document).on('keyup', '#search', function() {
          var query = $(this).val();
          fetch(query);
        });
      });
  </script>
</body>
</html>