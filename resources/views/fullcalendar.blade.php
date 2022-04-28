
<!DOCTYPE html>
<html>
<head>
    <title>Calendar</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        body {
            background-image: url('{{url("images/web.png")}}');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }
        #calendar .fc-day-header{
            background-color: skyblue;
        }
    </style>
    
</head>
<body>
    <div >
@include('navigation-menu')
<div style="display: flex;justify-content:center;">
        <div class="calendar">
        <div class="key">
        <img src="{{url('images/key.png')}}" alt="key" style="height: 3em;width:3em">
        <div style="display:flex;flex-direction:column;align-items:center;gap:2px">
            <div style="height:13px;width: 13px;border-radius: 50%;background:#f9a35c"></div>
            <div>Yours</div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:center;gap:2px">
            <div style="height:13px;width: 13px;border-radius: 50%;background:#92baff"></div>
            <div>Others</div>
        </div>
        <div style="display:flex;flex-direction:column;align-items:center;gap:2px">
            <div style="height:13px;width: 13px;border-radius: 50%;background:#7fa1bc"></div>
            <div>expired</div>
        </div>
        </div>
            <div id='calendar'></div>
        </div>
</div>
   
<script>
$(document).ready(function () {
    events={!!json_encode($events)!!};

    $('#calendar').fullCalendar({
                    editable: false,
                    displayEventTime: false,
                    selectable: true,
                    height:1300,
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay',
                    },
                    events:events,
                });

                $('#calendar .fc-event').each(function(){
                    var text = $(this).text();
                    if(text.indexOf(0)){
                        $(this).html(text);
                    }else{
                        text = text.replace(' ',"<br>");
                        $(this).html(text);
                    }
                })
});
 
</script>
</div>
</body>
</html>