<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Contact</title>
  <link rel="stylesheet" href="contactC.css" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

  <script>
    const inputs = document.querySelectorAll(".input");

    function focusFunc() {
      let parent = this.parentNode;
      parent.classList.add("focus");
    }

    function blurFunc() {
      let parent = this.parentNode;
      if (this.value == "") {
        parent.classList.remove("focus");
      }
    }

    inputs.forEach((input) => {
      input.addEventListener("focus", focusFunc);
      input.addEventListener("blur", blurFunc);

    });
    // countries drop down list 

    document.addEventListener('DOMContentLoaded', () => {

      const selectDrop = document.querySelector('#countries');
      // const selectDrop = document.getElementById('countries');


      fetch('https://restcountries.com/v2/all?fields=name,capital,currencies').then(res => {
        return res.json();
      }).then(data => {
        let output = "";
        data.forEach(country => {
          output += `
      
      <option value="${country.name}">${country.name}</option>`;
        })

        selectDrop.innerHTML = output;
      }).catch(err => {
        console.log(err);
      })


    });
  </script>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
body{
  background: rgb(236, 219, 162);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center
}
    input,
    textarea {
      font-family: "Poppins", sans-serif;
    }

    .container {
      position: relative;
      width: 100%;
      min-height: 100vh;
     
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .form {
      width: 100%;
      max-width: 820px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.1);
      z-index: 1000;
      overflow: hidden;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
    }

    .contact-form {
      position: relative;
      background-color: rgb(235, 191, 111);

    }

    .circle {
      border-radius: 50%;
      background: linear-gradient(135deg, transparent 20%, #05a3a4);
      position: absolute;
    }

    .circle.one {
      width: 130px;
      height: 130px;
      top: 130px;
      right: -40px;
    }

    .circle.two {
      width: 80px;
      height: 80px;
      top: 10px;
      right: 30px;
    }

    .contact-form:before {
      content: "";
      position: absolute;
      width: 26px;
      height: 26px;
      background-color: rgb(235, 191, 111)
        /*#f6ac8b*/
      ;
      transform: rotate(45deg);
      top: 50px;
      left: -13px;
    }

    #form {
      padding: 2.3rem 2.2rem;
      overflow: hidden;
      position: relative;
    }


    .title {
      color: #fff;
      font-weight: 500;
      font-size: 1.5rem;
      line-height: 1;
      margin-bottom: 0.7rem;
    }

    .input-container {
      position: relative;
      margin: 1rem 0;
    }

    .input {
      width: 100%;
      outline: none;
      border: 2px solid #fff;
      background: none;
      padding: 0.6rem 1.2rem;
      color: #fff;
      font-weight: 500;
      font-size: 0.95rem;
      letter-spacing: 0.5px;
      border-radius: 25px;
      transition: 0.3s;
    }

    textarea.input {
      padding: 0.8rem 1.2rem;
      min-height: 100px;
      border-radius: 22px;
      resize: none;
      overflow-y: auto;
    }
    .btn {
      padding: 0.6rem 1.3rem;
      background-color: #fff;
      border: 2px solid #fff;
      font-size: 0.95rem;
      color: #05a3a4;
      line-height: 1;
      border-radius: 25px;
      outline: none;
      cursor: pointer;
      transition: 0.3s;
      margin: 0;
      margin-top: 10px;
    }

    .btn:hover {
      background-color: #05a3a4;
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

      .square {
        transform: translate(140%, 43%);
        height: 350px;
      }

      .big-circle {
        bottom: 75%;
        transform: scale(0.9) translate(-40%, 30%);
        right: 50%;
      }

      .text {
        margin: 1rem 0 1.5rem 0;
      }

      .social-media {
        padding: 1.5rem 0 0 0;
      }
    }

    @media (max-width: 480px) {
      .container {
        padding: 1.5rem;
      }

      .contact-info:before {
        display: none;
      }

      .square,
      .big-circle {
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

  @include('navigation-menu')
  @if(session()->has('message'))
        <div id="hh" class="alert alert-success">
            {{session()->get('message')}}
        </div>
  @endif

  <div class="container">
    <span class="big-circle"></span>
    <img src="img/shape.png" class="square" alt="" />
    <div class="form">
      <div class="contact-info">



        <div class="social-media">
          <div class="social-icons">

          </div>
        </div>
      </div>

      <div class="contact-form">
        <span class="circle one"></span>
        <span class="circle two"></span>

        <form id="form" action="{{ url('/user/sendedEmail') }}" method="get">
          <h3 class="title">Contact </h3>
          <div class="input-container">
            <select style="color:grey" required name="email" class="input">
              <option>Select an email</option>
              @foreach($users as $user)
              <option style="color:black">{{ $user->email }}</option>
              @endforeach
            </select>
          </div>
          <div class="input-container textarea">
            <textarea style="color:black" required name="message" class="input" placeholder="Enter your Message"></textarea>
          </div>
          <input type="submit" value="Send" class="btn" />
        </form>
      </div>
    </div>
  </div>



</body>

</html>