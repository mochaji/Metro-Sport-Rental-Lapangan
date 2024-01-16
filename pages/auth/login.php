<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fieldrent</title>
        <style>
        @import url(//fonts.googleapis.com/css?family=Lato:300:400);

        body {
        margin:0;
        }

        h1 {
        font-family: 'Lato', sans-serif;
        font-weight:300;
        letter-spacing: 2px;
        font-size:32px;
        }
        p {
        font-family: 'Lato', sans-serif;
        letter-spacing: 1px;
        font-size:14px;
        color: #333333;
        }

        .header {
        position:relative;
        text-align:center;
        background: linear-gradient(60deg, rgba(84,58,183,1) 0%, rgba(0,172,193,1) 100%);
        color:white;
        }
        .logo {
        width:50px;
        fill:white;
        padding-right:15px;
        display:inline-block;
        vertical-align: middle;
        }

        .inner-header {
        height:65vh;
        width:100%;
        margin: 0;
        padding: 0;
        }

        .flex-column { /*Flexbox for containers*/
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        }

        .flex { /*Flexbox for containers*/
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        }

        .waves {
        position:relative;
        width: 100%;
        height:15vh;
        margin-bottom:-7px; /*Fix for safari gap*/
        min-height:100px;
        max-height:150px;
        }

        .content {
        position:relative;
        height:20vh;
        text-align:center;
        background-color: white;
        }

        /* Animation */

        .parallax > use {
        animation: move-forever 25s cubic-bezier(.55,.5,.45,.5)     infinite;
        }
        .parallax > use:nth-child(1) {
        animation-delay: -2s;
        animation-duration: 7s;
        }
        .parallax > use:nth-child(2) {
        animation-delay: -3s;
        animation-duration: 10s;
        }
        .parallax > use:nth-child(3) {
        animation-delay: -4s;
        animation-duration: 13s;
        }
        .parallax > use:nth-child(4) {
        animation-delay: -5s;
        animation-duration: 20s;
        }

        a {
        text-decoration: none;
        }

        label {
        font-family: "Raleway", sans-serif;
        font-size: 11pt;
        }
        #forgot-pass {
        color: rgba(84,58,183,1);
        font-family: "Raleway", sans-serif;
        font-size: 10pt;
        margin-top: 3px;
        text-align: right;
        }
        .card {
        z-index: 999;
        background: #fbfbfb;
        border-radius: 20px;
        box-shadow: 5px 8px 10px rgba(84,58,183,0.2);
        height: 410px;
        margin: 1rem 8.1rem ;
        width: 329px;
        }
        #card-content {
        padding: 44px 44px;
        }
        #card-title {
        font-family: "Raleway Thin", sans-serif;
        letter-spacing: 4px;
        padding-bottom: 23px;
        padding-top: 13px;
        text-align: center;
        }
        #signup {
        color: rgba(84,58,183,1);
        font-family: "Raleway", sans-serif;
        font-size: 10pt;
        margin-top: 16px;
        text-align: center;
        }
        #submit-btn {
        background: linear-gradient(60deg, rgba(84,58,183,1) 0%, rgba(0,172,193,1) 100%);
        border: none;
        border-radius: 21px;
        box-shadow: 0px 1px 8px rgba(84,58,183,1);
        cursor: pointer;
        color: white;
        font-family: "Raleway SemiBold", sans-serif;
        height: 42.3px;
        margin: 0 auto;
        margin-top: 50px;
        transition: 0.25s;
        width: 153px;
        }
        #submit-btn:hover {
        box-shadow: 0px 1px 18px rgba(0,172,193,1);
        }
        .form {
        align-items: left;
        display: flex;
        flex-direction: column;
        }
        .form-border {
        background: linear-gradient(60deg, rgba(84,58,183,1) 0%, rgba(0,172,193,1) 100%);
        height: 1px;
        width: 100%;
        }
        .form-content {
        background: #fbfbfb;
        border: none;
        outline: none;
        padding-top: 14px;
        }
        .underline-title {
        background: linear-gradient(60deg, rgba(84,58,183,1) 0%, rgba(0,172,193,1) 100%);
        height: 2px;
        margin: -1.1rem auto 0 auto;
        width: 89px;
        }


        @keyframes move-forever {
        0% {
        transform: translate3d(-90px,0,0);
        }
        100% { 
            transform: translate3d(85px,0,0);
        }
        }
        /*Shrinking for mobile*/
        @media (max-width: 768px) {
            .waves {
                height:40px;
                min-height:40px;
            }
            .content {
                height:30vh;
            }
            h1 {
                font-size:24px;
            }

            .inner-header{
                height:80vh;
            }

            .card{
                width: 80%;
                height: auto;
                margin: 0;
            }
        }


        </style>
    </head>

<!--Hey! This is the original version
of Simple CSS Waves-->

<div class="header">

<!--Content before waves-->
<div class="inner-header flex-column">
<!--Just the logo.. Don't mind this-->
<!-- <svg version="1.1" class="logo" baseProfile="tiny" id="Layer_1" xmlns="http://www.w3.org/2000/svg"
xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 500" xml:space="preserve">
<path fill="#FFFFFF" stroke="#000000" stroke-width="10" stroke-miterlimit="10" d="M57,283" />
<g><path fill="#fff"
d="M250.4,0.8C112.7,0.8,1,112.4,1,250.2c0,137.7,111.7,249.4,249.4,249.4c137.7,0,249.4-111.7,249.4-249.4
C499.8,112.4,388.1,0.8,250.4,0.8z M383.8,326.3c-62,0-101.4-14.1-117.6-46.3c-17.1-34.1-2.3-75.4,13.2-104.1
c-22.4,3-38.4,9.2-47.8,18.3c-11.2,10.9-13.6,26.7-16.3,45c-3.1,20.8-6.6,44.4-25.3,62.4c-19.8,19.1-51.6,26.9-100.2,24.6l1.8-39.7		c35.9,1.6,59.7-2.9,70.8-13.6c8.9-8.6,11.1-22.9,13.5-39.6c6.3-42,14.8-99.4,141.4-99.4h41L333,166c-12.6,16-45.4,68.2-31.2,96.2	c9.2,18.3,41.5,25.6,91.2,24.2l1.1,39.8C390.5,326.2,387.1,326.3,383.8,326.3z" />
</g>
</svg> -->
<h1>Login to Fieldrent</h1>
  <div id="card" class="card">
    <div id="card-content">
      <form method="post" class="form">
        <label for="user-email" style="padding-top:13px;color:rgba(84,58,183,1);text-align:left">
            &nbsp;Email
          </label>
        <input id="user-email" class="form-content" type="email" name="email" autocomplete="on" required />
        <div class="form-border"></div>
        <label for="user-password" style="padding-top:22px;;color:rgba(84,58,183,1);text-align:left">&nbsp;Password
          </label>
        <input id="user-password" class="form-content" type="password" id="password" required />
        <div class="form-border"></div>
        <a href="#">
          <legend id="forgot-pass">Forgot password?</legend>
        </a>
        <button id="submit-btn" type="button" onclick="login()">SUBMIT</button>
        <!-- <a href="#" id="signup">Don't have account yet?</a> -->
      </form>
    </div>
  </div>
</div>

<!--Waves Container-->
<div>
<svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
<defs>
<path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
</defs>
<g class="parallax">
<use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7" />
<use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
<use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.3)" />
<use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
</g>
</svg>
</div>
<!--Waves end-->

</div>
<!--Header ends-->

<!--Content starts-->
<div class="content flex">
  <p>Animated BG By.Goodkatz</p>
</div>
<!--Content ends-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>  
<script>
    function login(){
        var email = $("#user-email").val();
        var pass = $("#user-password").val();
        console.log(email);
        console.log(pass);
        $.ajax({
            url : "../../app/auth/login.php",
            type : "POST",
            data : {
                email : email,
                password : pass
            },
            dataType : "JSON",
            success : function(response){
              if (response.code==200) {
                  window.location.href = "../../index.php"                
              }else{
                  alert(response.message);
              }
            }
        })
    }
</script>