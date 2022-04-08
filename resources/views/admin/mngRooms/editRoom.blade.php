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
</head>
<body style="background:rgb(236, 219, 162)">
  <div >
  @include('admin.navigation-menu')
  <div style="width:40%;margin:80px auto 0 auto;border-radius:15px;background:rgba(255, 255, 255, 0.658);padding:20px">
    
    <form action="{{ url('/update/'.$room->id) }}" method="post">
                  @csrf
                  <div  style="display:flex;flex-direction:column;gap:10px;">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                  <div class="form-group">
                    <label>Name</label>
                    <input required name="name" value="{{ $room->name }}" class="form-control" type="text" placeholder="Enter TD or TP or Hall + Room/Hall Number">
                </div>
                <div class="form-group">
                  <label>Capacity</label>
                  <input required name="capacity" value="{{ $room->capacity }}" class="form-control" type="number" min="1" placeholder="Enter Capacity">
                  </div>
                  <div class="form-group">
                    <label>Floor</label>
                    <input required name="floor" value="{{ $room->floor }}" class="form-control" type="number" min="1" placeholder="Enter Floor">
                  </div>
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
            <input style="margin-top: 20px" type="submit" class="btn btn-info" value="Save">
            <input style="margin-top: 20px" type="reset" class="btn btn-info" value="Reset">
        </div>
          </form>
        </div>
</body>
</html>

