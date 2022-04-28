<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact</title>
  <link rel="stylesheet" href="contactC.css" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      background-image: url('{{url("images/web.png")}}');
      background-size: cover;
      background-repeat: no-repeat;
    }

    input,
    textarea {
      font-family: "Poppins", sans-serif;
    }

    .container {
      position: relative;
      width: 100%;
      height: 93.9vh;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form {
      max-width: 70%;
      min-height: 70vh;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.1);
      z-index: 2;
      overflow: hidden;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
    }

    .contact-form {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      background-color: #9fb6fa;

    }

    #form {
      overflow: hidden;
      position: relative;
    }

    .title {
      color: #fff;
      font-weight: 500;
      font-size: 30px;
      line-height: 1;
      margin-bottom: 2rem;
    }

    .input-container {
      position: relative;
      margin: 1rem 0;
    }

    .input {
      width: 90%;
      border: 1px solid gray;
      padding: 0.6rem 1.2rem;
      font-weight: 500;
      font-size: 0.95rem;
      letter-spacing: 0.5px;
      border-radius: 10px;
      transition: 0.3s;
    }

    textarea.input {
      padding: 0.8rem 1.2rem;
      min-height: 100px;
      border-radius: 10px;
      resize: none;
      overflow-y: auto;
    }

    .btn {
      padding: 0.6rem 1.3rem;
      background-color: #fff;
      border: 2px solid #fff;
      font-size: 0.95rem;
      line-height: 1;
      border-radius: 25px;
      outline: none;
      cursor: pointer;
      transition: 0.3s;
      margin: 0;
      margin-top: 10px;
    }

    .btn:hover {
      background-color: #f9a35c;
      color: #fff;
    }

    @media (max-width: 850px) {
      .form {
        grid-template-columns: 1fr;
      }

      .contact-info:before {
        bottom: initial;
        top: -75px;
        right: 65px;
        transform: scale(0.95);
      }

      .contact-form:before {
        top: -13px;
        left: initial;
        right: 70px;
      }

      .text {
        margin: 1rem 0 1.5rem 0;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 1.5rem;
      }

      .contact-info:before {
        display: none;
      }

      form,
      .contact-info {
        padding: 1.7rem 1.6rem;
      }

      .text,
      .information,
      .social-media p {
        font-size: 0.8rem;
      }

      .title {
        font-size: 1.15rem;
      }

      .social-icons a {
        width: 30px;
        height: 30px;
        line-height: 30px;
      }

      .icon {
        width: 23px;
      }

      .input {
        padding: 0.45rem 1.2rem;
      }

      .btn {
        padding: 0.45rem 1.2rem;
      }

    }
  </style>
  <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body>

  <div style="backdrop-filter: blur(4px);width:100%;height:100vh;display:flex;flex-direction: column;">
    @include('admin.navigation-menu')
    @if(session()->has('message'))
    <div id="hh" class="alert alert-success">
      {{session()->get('message')}}
    </div>
    @endif
    <div class="container">
      <div class="form">
        <div class="contact-info" style="display: flex;align-items:center">
          <img src="{{url('images/triggers.png')}}" alt="">
        </div>
        <div class="contact-form">
          <form id="form" action="{{ url('/admin/sendedEmail') }}" method="get">
            <h2 class="title">Contact</h2>
            <div class="input-container">
              <p style="color: #fff;text-align: start;margin-left:1.2rem">Email</p>
              <select style="color:grey;cursor: pointer;" required name="email" class="input">
                <option>Select</option>
                  @foreach($users as $user)
                    <option style="color:black">{{ $user->email }}</option>
                  @endforeach
              </select>
            </div>
            <div class="input-container textarea">
            <p style="color: #fff;text-align: start;margin-left:1.2rem">Message</p>
              <textarea style="color:black" required name="message" class="input" placeholder="Write.."></textarea>
            </div>
            <input type="submit" value="Send" class="btn" />
          </form>
        </div>
      </div>
    </div>
  </div>


</body>

</html>