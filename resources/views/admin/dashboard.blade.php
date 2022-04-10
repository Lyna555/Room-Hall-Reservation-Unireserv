<x-app-layout>
    @include('admin.navigation-menu')
    @if(session()->has('error'))
        <div class="alert alert-danger">
            {{session()->get('error')}}
        </div>
  @endif
</x-app-layout>
