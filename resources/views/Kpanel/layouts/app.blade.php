<html lang="en" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="light" data-toggled="close">

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>@yield('page-title') - Mockup Soft</title>

<!-- Favicons -->
<link rel="icon" href="{{asset('nowa-panel/assets/images/eva-favicon.png')}}">


<!-- Choices JS -->
<script src="{{asset('nowa-panel/assets/libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>

<!-- Main Theme Js -->
<script src="{{asset('nowa-panel/assets/js/main.js')}}"></script>

<!-- Bootstrap Css -->
<link id="style" href="{{asset('nowa-panel/assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

<!-- Style Css -->

<link href="{{asset('nowa-panel/assets/css/styles.css')}}" rel="stylesheet">

<!-- Icons Css -->
<link href="{{asset('nowa-panel/assets/css/icons.css')}}" rel="stylesheet">

<!-- Node Waves Css -->
<link href="{{asset('nowa-panel/assets/libs/node-waves/waves.min.css')}}" rel="stylesheet">

<!-- Simplebar Css -->
<link href="{{asset('nowa-panel/assets/libs/simplebar/simplebar.min.css')}}" rel="stylesheet">


<!-- Color Picker Css -->
<link rel="stylesheet" href="{{asset('nowa-panel/assets/libs/flatpickr/flatpickr.min.css')}}">
<link rel="stylesheet" href="{{asset('nowa-panel/assets/libs/@simonwep/pickr/themes/nano.min.css')}}">

<!-- Choices Css -->
<link rel="stylesheet" href="{{asset('nowa-panel/assets/libs/choices.js/public/assets/styles/choices.min.css')}}">
<link rel="stylesheet" href="{{asset('nowa-panel/assets/libs/jsvectormap/css/jsvectormap.min.css')}}">

<link rel="stylesheet" href="{{asset('nowa-panel/assets/libs/swiper/swiper-bundle.min.css')}}">
<link rel="stylesheet" href="{{asset("panel/assets/css/toastify.css")}}" type="text/css" />



@yield('CssContent')

<style type="text/css">/* Chart.js */
    @-webkit-keyframes chartjs-render-animation {
        from {
            opacity: 0.99
        }
        to {
            opacity: 1
        }
    }

    @keyframes chartjs-render-animation {
        from {
            opacity: 0.99
        }
        to {
            opacity: 1
        }
    }

    .chartjs-render-monitor {
        -webkit-animation: chartjs-render-animation 0.001s;
        animation: chartjs-render-animation 0.001s;
    }</style>
<style>
    .table thead tr th{
        text-wrap: nowrap;
    }
    .circle-container {
        position: relative;
        height: 70px;
        width: 70px;
    }

    .circle-progress {
        position: absolute;
        height: 100%;
        width: 100%;
        border-radius: 50%;
        border: 5px solid #cc1b7247;
        border-radius: 50%;
    }

    .circle-progress::before {
        content: "";
        position: absolute;
        height: 100%;
        width: 100%;
        border-radius: 50%;
        border: 5px solid transparent;
        border-top-color: #cc1b72;
        top: 0px;
        left: 0px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}"/>

</head>

<body>
<div class="pace  pace-inactive">
    <div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div>
</div>


<!-- Preloader -->
<div id="loader">
    <div class="circle-container">
        <div class="circle-progress"></div>
    </div>
</div>


<!-- Sidebar -->
{{--<aside class="sidebar sidebar-expand-lg sidebar-light sidebar-sm sidebar-color-info">--}}

{{--    @include('Kpanel.layouts.aside')--}}
{{--</aside>--}}
<!-- END Sidebar -->


<!-- Topbar -->
@include('Kpanel.layouts.topbar')
@include('Kpanel.layouts.aside')
<!-- END Topbar -->


<!-- Main container -->
<main class="main-container padding-content app-content">

    @yield('content')

    <!-- Footer -->
    <footer class="site-footer">
        <div class="row">
            <div class="col-md-12">
                <p class="text-center text-md-left">Copyright © 2022 <a href="https://mockupsoft.com/" target="_blank">
                        Mockup Soft</a>.
                    All rights reserved.</p>
            </div>

        </div>
    </footer>
    <!-- END Footer -->

</main>
<!-- END Main container -->


<div class="scrollToTop">
    <span class="arrow"><i class="ri-arrow-up-s-fill fs-20"></i></span>
</div>



<script src="{{asset('nowa-panel/assets/js/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset('nowa-panel/assets/libs/@popperjs/core/umd/popper.min.js')}}"></script>


<script src="{{asset('nowa-panel/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


<script src="{{asset('nowa-panel/assets/js/defaultmenu.min.js')}}"></script>
<script src="{{asset('nowa-panel/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/sticky.js')}}"></script>
<script src="{{asset('nowa-panel/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/simplebar.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/index.js')}}"></script>




<script src="{{asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>

<script src="{{asset('panel/assets/js/sweetalert2.min.js')}}"></script>
<script src="{{asset('panel/assets/js/toastify.js')}}"></script>


<!-- Popper JS -->
<script src="{{asset('nowa-panel/assets/libs/@popperjs/core/umd/popper.min.js')}}"></script>

<!-- Bootstrap JS -->
<script src="{{asset('nowa-panel/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Defaultmenu JS -->


<!-- Node Waves JS-->
<script src="{{asset('nowa-panel/assets/libs/node-waves/waves.min.js')}}"></script>

<!-- Sticky JS -->
<script src="{{asset('nowa-panel/assets/js/sticky.js')}}"></script>

<!-- Simplebar JS -->
<script src="{{asset('nowa-panel/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/simplebar.js')}}"></script>

<!-- Color Picker JS -->
<script src="{{asset('nowa-panel/assets/libs/@simonwep/pickr/pickr.es5.min.js')}}"></script>


<!-- JSVector Maps JS -->
<script src="{{asset('nowa-panel/assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>

<!-- JSVector Maps MapsJS -->
<script src="{{asset('nowa-panel/assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

<!-- Apex Charts JS -->
<script src="{{asset('nowa-panel/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- Chartjs Chart JS -->
<script src="{{asset('nowa-panel/assets/libs/chart.js/chart.min.js')}}"></script>

<!-- Index Js -->
<script src="{{asset('nowa-panel/assets/js/index.js')}}"></script>


<!-- Custom-Switcher JS -->

<!-- Custom JS -->
<script src="{{asset('nowa-panel/assets/js/custom.js')}}"></script>


<script>
    if(document.querySelectorAll('.telephone')){
        document.querySelectorAll('.telephone').forEach(function (item,index){
            IMask(item, {mask: '(000) 000 0000'});
        })
    }
    if(document.querySelectorAll('.tc_no')){
        document.querySelectorAll('.tc_no').forEach(function (item,index){
            IMask(item, {mask: '00000000000'});
        })
    }
    if(document.querySelector('input[name="phone"]')){
        document.querySelectorAll('input[name="phone"]').forEach(function (item,index){
            const maskTel = IMask(item, {
                mask: '(000) 000 0000'
            });
        })
    }
    $('#mainHeaderProfile').click(function(){
        $('.main-header-dropdown.dropdown-menu.header-profile-dropdown.dropdown-menu-end').toggleClass('show')
    })
</script>



@yield('JsContent')
</body>
</html>
