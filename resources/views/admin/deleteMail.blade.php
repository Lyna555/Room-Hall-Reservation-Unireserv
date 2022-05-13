<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    Hello,<br><br>
    Because the room "{{$reservation->room_name}}" is no more available, your reservation: <br><br>
    {{$reservation->room_name}} | {{$reservation->date}} | {{$reservation->creneaude}} | {{$reservation->creneaua}} <br><br> 
    has been deleted.<br><br>
    Unireserv Team.
</body>
</html>