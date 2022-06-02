<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Contact Us</title>
    <style>
        body {
            background-image: url('{{url("images/web.png")}}');
            background-size: cover;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        #cont {
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #calendar .fc-day-header {
            background-color: skyblue;
        }

        h1 {
            margin-bottom: 40px;
        }

        label {
            color: #333;
            margin-block: 10px;
        }

        .btn-send {
            background-color: #f89746;
            border: none;
            box-shadow: 3px 3px 7px rgba(0, 0, 0, 0.493);
            width: 80%;
            margin-left: 3px;
            margin-top: 20px;
        }

        .btn-send:hover {
            background-color: #f89760;
        }

        .help-block.with-errors {
            color: #ff5050;
            margin-top: 5px;

        }

        .card {
            margin-left: 10px;
            margin-right: 10px;
        }
    </style>
</head>

<body>

    <div id="cont">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 mx-auto">
                    <div class="card mt-2 mx-auto p-4 bg-light">
                        <div class="card-body bg-light">
                            <div class="container">
                                @if(session()->has('message'))
                                <div id="hh" class="alert alert-success">
                                    {{session()->get('message')}}
                                </div>
                                @endif
                                @if(session()->has('errorMEssage'))
                                <div id="hh" class="alert alert-success">
                                    {{session()->get('errorMessage')}}
                                </div>
                                @endif
                                <div class=" text-center">
                                    <h1>Contact Us</h1>
                                </div>
                                <form action="{{url('/welcomeContactusMail')}}" method="get" id="contact-form" role="form">
                                    <div class="controls">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_email">Email</label>
                                                    <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email" required="required" data-error="Valid email is required.">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="form_message">Message</label>
                                                    <textarea id="form_message" name="message" class="form-control" placeholder="Write your message here." rows="4" required="required" data-error="Please, leave us a message."></textarea>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="submit" class="btn btn-success btn-send  pt-2 btn-block" value="Send">
                                                </div>
                                                <div class="col-md-6">
                                                    <a class="btn btn-success btn-send  pt-2 btn-block" style="background-color: rgb(232,232,232);color:black" href="{{url('/')}}">Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>