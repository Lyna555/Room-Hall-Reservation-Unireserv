<x-app-layout>
    @include('navigation-menu')
    <div style="display:flex;flex-direction:column;gap:20px;width:60%;height:93.9vh;justify-content:center;align-items:center;position:absolute">
        <div style="display:flex;flex-direction:column;text-align:center;font-family:'Script MT';font-size:90px;line-height: 80px;">
            <div>Welcome to our</div>
            <div>unireserv</div>
        </div>
        <div style="text-align:center;font-size:15px;font-weight: bold;">Now you can book rooms and amphitheaters<br>in efficient, easy and fast way!</div>
        <a href="#more" onclick="document.getElementById('more').style.display='flex'" class="btn btn-info" style="background-color: skyblue;border:none;font-weight: bold;box-shadow: 0px 3px 6px gray;">More Details</a>
    </div>
    <div style="display: flex;width:100%;height:93.9vh;justify-content:end;align-items:end">
        <img src="{{URL('images/hall.png')}}" alt="">
    </div>
    <div id="more" style="width:99%;height:100vh;display:none;;justify-content:end;align-items:center">
        <div style="width:100%;height:80%;display:grid;grid-template-columns: repeat(2,25em);justify-content: center;gap:50px">
            <div class="cards" style="display:flex;justify-content:center;align-items: center;gap:20px;padding:10px">
                <img src="{{URL('images/calendar.png')}}" alt="calendar" style="height:6em;width:6em">
                <p>Our website provides you to see all reservations in your faculty using a calendar.</p>
            </div>
            <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px">
                <img src="{{URL('images/timetable.png')}}" alt="calendar" style="height:6em;width:6em">
                <p>You can reserve a Room/Hall easily and save your time!</p>
            </div>
            <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px">
                <img src="{{URL('images/email.png')}}" alt="calendar" style="height:6em;width:6em">
                <p>Contact other professors in your faculty if needed!</p>
            </div>
            <div class="cards" style="display:flex;justify-content: center;align-items: center;gap:20px;padding:10px">
                <img src="{{URL('images/notification.png')}}" alt="calendar" style="height:6em;width:6em;padding:10px">
                <p>If you reserve a speacial room, a notification will reach you that your reservation is accepted or refused !</p>
            </div>
        </div>
        <img onclick="document.getElementById('more').style.display='none'" src="{{url('images/up.png')}}" alt="up_arrow" style="position: absolute;cursor: pointer;height:3em;width:3em;">
    </div>
</x-app-layout>