<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<link rel="stylesheet" href="{{ mix('css/app.css') }}">
<script src="{{ mix('js/app.js') }}" defer></script>
  <title>Edit Reservation</title>
</head>
<body style="background:rgb(236, 219, 162)">
  <div >
  @include('admin.navigation-menu')
  <div id="div" style="width:40%;margin:80px auto 0 auto;border-radius:15px;background:rgba(255, 255, 255, 0.658);padding:20px">
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
    <form id="form" action="{{ url('/updateR/'.$reservation->id)}}" method="get">
                  @csrf
                  <div  style="display:flex;flex-direction:column;gap:10px;" >
                    <div class="form-group">
                        <label>Room/Hall Name</label>
                        <select required name="name">
                          <option>{{ $reservation->room_name }}</option>
                          <option ></option>
                          @foreach($rooms as $room)
                          <option>{{$room->name}}</option>
                          @endforeach
                        </select>  
                    </div>
                  <div class="form-group">
                    <label>Date</label>
                    <input required name="date" value="{{ $reservation->date }}" class="form-control" type="date" placeholder="Enter The Date">
                </div>
                <div class="form-group">
                    <label>Time</label>
                    <div style="display: flex; flex-direction:row; align-items:center; gap:10px;" >
                        <label>From</label>
                        <input required name="creneaude" value="{{ $reservation->creneaude }}" class="form-control" type="time" placeholder="Choose Entery-time">
                        <label>To</label>
                        <input name="creneaua" value="{{ $reservation->creneaua }}" class="form-control" type="time" placeholder="Choose Exittime">
                 </div></div>
              <div class="form-group">
            </div>
            <div class="form-group">
              <label>Objective</label>
              <select required name="objective">
                <option>{{ $reservation->objective }}</option>
                <option ></option>
                <option value="event">Event</option>
                <option value="lecture">Lecture</option>
              </select>
          </div>
            
          </div>
        <div style="display: flex;justify-content:center;gap:20px">
            <input style="margin-top: 20px" type="submit" class="btn btn-info" value="Save">
            <input style="margin-top: 20px" type="reset" class="btn btn-info" value="Reset">
        </div>
          </form>
  </div> 
</div> 
</body>
</html>
