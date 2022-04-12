<x-app-layout>
    @include('admin.navigation-menu')
    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{session()->get('error')}}
        </div>
  @endif
<div style="display: flex;width:100%;height:90vh;justify-content:left;align-items:center">
<img src="{{URL('images/image2.png')}}" style="height:80vh;width:50%"  alt="">

</div>

</x-app-layout>
