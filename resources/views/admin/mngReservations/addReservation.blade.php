<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script src="{{ mix('js/app.js') }}" defer></script>
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <style>
    body {
      background-image: url('{{url("images/web.png")}}');
      background-size: cover;
      background-repeat: no-repeat;
    }
  </style>
  <title>Add Reservations</title>
</head>

<body>
  @include('admin.navigation-menu')
  <div style="width:100%;height:93.9vh;display: flex;flex-direction: column;justify-content: center;align-items: center;">
    <div id="div" style="width:40%;border-radius:15px;background:rgba(255, 255, 255, 0.9);padding:20px;box-shadow: 0px 4px 15px gray;">
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

      <form id="form" action="{{ url('/storeR')}}" method="get">
        @csrf
        <div style="display:flex;flex-direction:column;gap:10px;">
          <div class="form-group">
            <label>Room/Hall Name</label>
            <select required name="name">
              <option></option>
              @foreach($rooms as $room)
              @if($room->state!='speacial')
              <option value="{{$room->name}}">{{$room->name}} (Capacity: {{$room->capacity}}, Floor: {{$room->floor}})</option>
              @else
              <option value="{{$room->name}}" style="background-color: #A4C8D5;">{{$room->name}} (Capacity: {{$room->capacity}}, Floor: {{$room->floor}})</option>
              @endif
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label>Date</label>
            <input required name="date" class="form-control" type="date" placeholder="Enter The Date">
          </div>
          <div class="form-group">
            <label>Time </label>
            <div style="display: flex; flex-direction:row; align-items:center; gap:10px;">
              <label>From</label>
              <input required name="creneaude" class="form-control" type="time" placeholder="Choose Entery-time">
              <label>To</label>
              <input required name="creneaua" class="form-control" type="time" placeholder="Choose Exit-time">
            </div>
          </div>
          <div class="form-group">
          </div>
          <div class="form-group">
            <label>Objective</label>
            <select required name="objective">
              <option></option>
              <option value="event">Event</option>
              <option value="lecture">Lecture</option>
            </select>
          </div>

        </div>
        <div style="display: flex;justify-content:center;gap:20px">
          <input type="submit" class="btn btn-info" style="margin-top: 20px;background-color: #f9a35c;color:white;border:none;box-shadow: 0px 2px 4px gray;border-radius:15px;padding:3.7px 23.7px" value="Save">
          <a href="{{url('/admin/showReser')}}" style="text-decoration: none;margin-top: 20px;background-color: #a4c8d5;color:white;border:none;box-shadow: 0px 2px 4px gray;border-radius:15px;padding:3.7px 15px;">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>