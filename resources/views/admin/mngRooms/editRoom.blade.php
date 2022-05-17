<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Edit Room/Hall</title>
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
</head>

<body>
  @include('admin.navigation-menu')
  <div style="width:100%;height:93.9vh;display: flex;flex-direction: column;justify-content: center;align-items: center;">
    <div class="div">

      <form action="{{ url('/update/'.$room->id) }}" method="post">
        @csrf
        <div style="display:flex;flex-direction:column;gap:10px;">
        <div style="text-align: center;font-weight: bold;font-size: 20px;">Edit Room</div>
          @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          @if($room->type=='TD')
          <div class="form-group">
            <label>Type</label>
            <select required name="type">
              <option value="TD">TD</option>
              <option value="TP">TP</option>
              <option value="Hall">Hall</option>
            </select>
          </div>
          @elseif($room->type=='TP')
          <div class="form-group">
            <label>Type</label>
            <select required name="type">
              <option value="TP">TP</option>
              <option value="TD">TD</option>
              <option value="Hall">Hall</option>
            </select>
          </div>
          @elseif($room->type=='Hall')
          <div class="form-group">
            <label>Type</label>
            <select required name="type">
              <option value="Hall">Hall</option>
              <option value="TD">TD</option>
              <option value="TP">TP</option>
            </select>
          </div>
          @endif
          <div class="form-group">
            <label>Number</label>
            <input required name="number" value="{{ $num }}" class="form-control" type="number" placeholder="Enter Room/Hall Number">
          </div>
          <div class="form-group">
            <label>Capacity</label>
            <input required name="capacity" value="{{ $room->capacity }}" class="form-control" type="number" min="1" placeholder="Enter Capacity">
          </div>
          <div class="form-group">
            <label>Floor</label>
            <input required name="floor" value="{{ $room->floor }}" class="form-control" type="number" min="0" placeholder="Enter Floor">
          </div>

          @if($room->state=='ordinary')
          <div class="form-group">
            <label>State</label>
            <select name="state">
              <option value="ordinary">Ordinary</option>
              <option value="speacial">Speacial</option>
            </select>
          </div>
          @elseif($room->state=='speacial')
          <div class="form-group">
            <label>State</label>
            <select name="state">
              <option value="speacial">Speacial</option>
              <option value="ordinary">Ordinary</option>
            </select>
          </div>
          @endif


          @if(session()->has('errorMessage'))
          <div id="hh" class="alert alert-danger">
            {{session()->get('errorMessage')}}
          </div>
          @endif
        </div>
        <div style="display: flex;justify-content:center;gap:20px">
          <input type="submit" class="btn btn-info" style="margin-top: 20px;background-color: #f9a35c;color:white;border:none;box-shadow: 0px 2px 4px gray;border-radius:15px;padding:3.7px 23.7px" value="Save">
          <a href="{{url('/showList')}}" style="text-decoration: none;margin-top: 20px;background-color: #a4c8d5;color:white;border:none;box-shadow: 0px 2px 4px gray;border-radius:15px;padding:3.7px 15px;">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</body>

</html>