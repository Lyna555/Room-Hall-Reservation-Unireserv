<x-app-layout>
    @include('admin.navigation-menu')
    @if(session()->has('error'))
    <div class="alert alert-danger">
        {{session()->get('error')}}
    </div>
    @endif
    <div style="display:flex;width:60%;height:93.9vh;justify-content:center;align-items:center;position:absolute">
    <pre style="text-align:center;font-family: 'Script MT';font-size: 90px;">Welcome to our
    website
    </pre>
    </div>
    <div style="display:flex;width:100%;height:93.9vh;justify-content:end;align-items:end">
        <img src="{{URL('images/douaa.png')}}" alt="event">
    </div>

</x-app-layout>