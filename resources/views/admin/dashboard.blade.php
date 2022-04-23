<x-app-layout>
    @include('admin.navigation-menu')
    @if(session()->has('error'))
    <div class="alert alert-danger">
        {{session()->get('error')}}
    </div>
    @endif
    <div style="display:flex;flex-direction:column;gap:20px;width:60%;height:93.9vh;justify-content:center;align-items:center;position:absolute">
        <div style="display:flex;flex-direction:column;text-align:center;font-family:'Script MT';font-size:90px;line-height: 80px;">
            <div>Welcome to our</div>
            <div>Unireserv</div>
        </div>
        <div style="text-align:center;font-size:15px;font-weight: bold;">Now you can book rooms and amphitheaters<br>in efficient, easy and fast way!</div>
        <a href="#" class="btn btn-info" style="background-color: skyblue;border:none;font-weight: bold;box-shadow: 0px 3px 6px gray;">Explore</a>
    </div>
    <div style="display:flex;width:100%;height:93.9vh;justify-content:end;align-items:end">
        <img src="{{URL('images/douaa.png')}}" alt="event">
    </div>

</x-app-layout>