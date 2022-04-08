<div style="background:url('{{ URL('images/back.jpeg') }}');background-size:100%;">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0" style="backdrop-filter:blur(1px); background-color:#00000038">

    <div class=" w-full mt-6 px-6 py-4 shadow-md" style="width:30%;background-color: rgba(255, 255, 255, 0.452); border-radius:30px;" >
        <div class="flex flex-col sm:justify-center items-center"> {{ $logo }}</div>
        {{ $slot }}
    </div>
    </div>
</div>
