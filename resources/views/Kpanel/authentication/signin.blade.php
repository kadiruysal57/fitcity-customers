<html lang="en">
<link type="text/css" rel="stylesheet" id="dark-mode-custom-link">
<link type="text/css" rel="stylesheet" id="dark-mode-general-link">
<style lang="en" type="text/css" id="dark-mode-custom-style"></style>
<style lang="en" type="text/css" id="dark-mode-native-style"></style>
<style lang="en" type="text/css" id="dark-mode-native-sheet"></style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords" content="login, signin">

    <title>Eva Gym Giriş Yap</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('panel/assets/css/core.min.css')}}" rel="stylesheet">
    <link href="{{asset('panel/assets/css/app.min.css')}}" rel="stylesheet">
    <link href="{{asset('panel/assets/css/style.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset("panel/assets/css/toastify.css")}}" type="text/css"/>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{asset('panel/assets/img/apple-touch-icon.png')}}">
    <link rel="icon" href="{{asset('nowa-panel/assets/images/fitcity-favicon.png')}}">
    <style type="text/css">
        header {
            background-color: #fff !important;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            border: 1px solid #cbccd0;
            width: 100vw;
            height: 80px;
            font-family: Barlow Condensed, sans-serif;
            background-color: #fff;
            padding: 0 20px;
            text-align: center;
        }

        header div {
            width: 100%;
        }
        header div img {
            max-width: 90px;
        }
        body{
            background-color: #fff !important;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

</head>

<body class="  pace-done">
<header>
    <div class="text-center">
        <img src="{{asset('/nowa-panel/assets/images/logo.png')}}" alt="">
    </div>
</header>
<div class="pace  pace-inactive">
    <div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div>
</div>

<!-- Preloader -->
<div class="preloader" style="display: block;">
    <div class="spinner-dots spinner-dots min-h-fullscreen center-vh mx-auto">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
    </div>
</div>

<div class="row min-h-fullscreen center-vh p-20 m-0" >

    <div class="col-12">
        <div class="card  px-150 py-30 w-700px mx-auto"  style="border-radius: 15px;    border-radius: 15px;
    border-radius: 12px;
    -webkit-box-shadow: 0 4px 8px 0 rgba(0, 0, 0, .16);
    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, .16);
    border: 1px solid #cbccd0;">

            <h5 class="text-uppercase text-black text-center">{{__('auth.signin')}}</h5>
            <br>

            @if(isset($_GET['telephone']) && $_GET['telephone'] != '')
                <form class="form-type-material" method="post" action="{{route('sign_in_post_sms')}}">@csrf
                    <input type="hidden" class="telephone" name="telephone" value="{{ $_GET['telephone'] }}">
                    <div class="form-group">
                        <input type="text" value="" minlength="4" maxlength="4" class="form-control" required=""
                               id="sms_login_code" name="sms_login_code">
                        <label for="sms_login_code">Sms Kodu</label>
                    </div>
                    <div class="form-group border-none">
                        <button class="btn btn-bold btn-block btn-primary" type="submit">{{__('auth.login')}}</button>
                    </div>
                </form>
            @else
                <form class="form-type-material" id="sing-in-form" action="{{route('sign_in_post')}}">
                    <div class="input-group">

                        <input type="text" value="{{$_GET['telefon'] ?? ''}}" class="form-control telephone" required="" id="telephone"
                               name="telephone" placeholder="{{__('auth.phone')}}">
                    </div>

                    <div class="input-group">
                        <input type="password" value="" class="form-control" required="" placeholder="{{__('auth.passwords')}}" id="password" name="password">
                    </div>

                    <div class="input-group flexbox flex-column flex-md-row border-none">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember_me" class="custom-control-input" checked="">
                            <label class="custom-control-label">{{__('auth.rememberme')}}</label>
                        </div>
                    </div>

                    <div class="form-group border-none">
                        <button class="btn btn-bold btn-block btn-primary" type="submit">{{__('auth.login')}}</button>
                    </div>

                    <div class="form-group border-none text-center font-bold">
                        Üye Değil misiniz?
                        <a class="text-muted hover-primary fs-13 mt-2 mt-md-0"
                           href="{{route('register')}}">{{__('auth.register')}}</a>
                    </div>

                </form>
            @endif


        </div>
    </div>


    <footer class="col-12 align-self-end text-center fs-13">
        <p class="mb-0"><small>Copyright © 2019 <a href="https://mockupsoft.com/">Mockup Soft</a>. All rights
                reserved.</small></p>
    </footer>
</div>


<!-- Scripts -->


<script src="{{asset('panel/assets/js/core.min.js')}}"></script>
<script src="{{asset('panel/assets/js/app.min.js')}}"></script>
<script src="{{asset('panel/assets/js/script.js')}}"></script>
<script src="{{asset('panel/assets/js/toastify.js')}}"></script>
<script src="{{asset('panel/assets/js/authentication/signin.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset('panel/assets/js/imask.js')}}"></script>
<script>
    $(document).ready(function () {
        if (document.querySelectorAll('.telephone')) {
            console.log(document.querySelectorAll('.telephone'));
            document.querySelectorAll('.telephone').forEach(function (item, index) {
                console.log(item, index)
                IMask(item, {mask: '(000) 000 0000'});
            })
        }
    })
</script>
