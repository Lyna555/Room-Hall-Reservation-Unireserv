<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    This room {{$roomy->name}} that you reserved has undergone the following changes: <br><br>
    @if($roomy->name!=$room)
        Its name bacome: {{$room}}
        <br>
    @endif

    @if($roomy->capacity!=$capacity)
        Its capacity become: {{$capacity}}
        <br>
    @endif

    @if($roomy->floor!=$floor)
        Its floor become: {{$floor}}
    @endif
    <br><br>
    Regards
</body>
</html>