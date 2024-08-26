<html lang="en">
<link type="text/css" rel="stylesheet" id="dark-mode-custom-link">
<link type="text/css" rel="stylesheet" id="dark-mode-general-link">
<style lang="en" type="text/css" id="dark-mode-custom-style"></style>
<style lang="en" type="text/css" id="dark-mode-native-style"></style>
<style lang="en" type="text/css" id="dark-mode-native-sheet"></style>
<head>
    <script src="http://thetheme.io/theadmin/page-extra/../assets/vendor/typeahead/typeahead.jquery.min.js"></script>
    <script src="http://thetheme.io/theadmin/page-extra/../assets/vendor/typeahead/bloodhound.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">


    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="login, signin">

    <title>Eva Gym Kayıt Ol</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link href="{{asset('panel/assets/css/core.min.css')}}" rel="stylesheet">
    <link href="{{asset('panel/assets/css/app.min.css')}}" rel="stylesheet">
    <link href="{{asset('panel/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('nowa-panel/assets/css/register.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset("panel/assets/css/toastify.css")}}" type="text/css"/>

    <!-- Favicons -->
    <link rel="apple-touch-icon" href="{{asset('panel/assets/img/apple-touch-icon.png')}}">
    <link rel="icon" href="{{asset('panel/assets/img/favicon.png')}}">
    <style type="text/css">
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <style>


    </style>
</head>

<body class="  pace-done">
<header>
    <div class="text-center logo-content col-md-12 ">
        <img src="{{asset('/nowa-panel/assets/images/logo.png')}}" alt="">
    </div>
    <div class="text-center breamcrub-content d-none">
        <ul class="header-list">
            <li class="user_phone">TELEFON NUMARASI</li>
            <li class="user_type">ÜYELİK TİPİ</li>
            <li class="membership_info">KİŞİSEL BİLGİLER</li>
            <li class="payment">ÖDEME</li>
        </ul>
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

<div class="row min-h-fullscreen p-20 m-0">

    <div class="col-12">


        <br>
        @if(!empty($_GET['telefon']) && $_GET['telefon'] != '')
            <div class="card  px-150 py-30 w-700px mx-auto" style="border-radius: 15px;">
                <form class="form-type-material" method="post" action="{{route('register_post_sms')}}">@csrf
                    <input type="hidden" class="telephone" name="telephone" value="{{ $_GET['telefon'] }}">
                    <div class="form-group">
                        <input type="text" value="" minlength="4" maxlength="6" class="form-control" required=""
                               id="sms_login_code" name="sms_login_code">
                        <label for="sms_login_code">Sms Kodu</label>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-bold btn-block btn-primary" type="submit">{{__('auth.login')}}</button>
                    </div>
                </form>
            </div>
        @else
            <form class="form-type-material mt-5" id="register-form-pay"
                  action="{{route('getCustomerRegister')}}">


                <div class="step-1">
                    <h2 class="text-center text-bold text-black mb-5">Bize katılmak için hazırsın!</h2>
                    <div class="card w-700px mx-auto">
                        <h5 class="text-center">Sana özel tekliflerimizden haberdar olmak için telefon
                            numaranı gir</h5>


                        <div class="registerphone">
                            <div class="input-group">
                                <select id="country-code" name="country-code">
                                    <option value="90">+90</option>
                                </select>

                                <input type="tel" id="phone-number" name="phone-number" placeholder="(5xx) xxx-xxxx">
                            </div>


                            <div class="form-group border-none">
                                <button type="button" class="btn btn-bold btn-block btn-primary" id="next_step_2">Üyelik
                                    Paketlerini Gör
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center text-black">
                        Kişisel verileriniz <a href="#" class="text-bold">Aydınlatma Metni</a> kapsamında işlenmektedir.
                    </div>
                </div>
                <div class="step-2 d-none">
                <span class="step-title">
                    Kendine en uygun <br> üyelik paketini seç
                </span>
                    <div class="step-button">
                        <span class="year span-active">Yıllık</span>
                        <span class="month">Aylık</span>
                    </div>
                    <div class="step-content">
                        <div class="step-content-year col-12">
                            <div class="row">
                                @foreach($year_packages as $year)
                                    <div class="col-md-4 col-12 ">
                                        <input type="radio" name="packages_id" value="{{$year->id}}" class="d-none"
                                               id="package_id_{{$year->id}}">
                                        <div class="card-package card-package">
                                            <div class="package-top">
                                                <div class="type-name">{{$year->name}}</div>
                                                <div class="type-fee">
                                                    {{$year->discount_price}} TL
                                                    <span class="type-fee-info month-tr"> / AYDA </span>
                                                </div>
                                                <div class="type-fee old-price">
                                                    {{$year->price}} TL
                                                </div>
                                                <div class="type-extra">
                                                    1 Yıl Kalma Sözüne {{$year->discount_rate}}% İndirim
                                                </div>
                                                <div class="col-12 text-center">
                                                    <button type="button"
                                                            class="btn btn-bold btn-block btn-primary select_radio"
                                                            data-summarytext="1"
                                                            data-price="{{$year->discount_price}} TL/AYDA"
                                                            data-name="{{$year->name}} - Yıllık"
                                                            data-id="{{$year->id}}">Üyelik
                                                        Paketi Seç
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="package-bottom">
                                                <ul>
                                                    @if(!empty($year->detils))
                                                        @foreach($year->detils as $detail)
                                                            <li><i class="fa fa-check"></i> {{$detail->description}}
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="step-content-month col-12 d-none">
                            <div class="row">
                                @foreach($month_packages as $year)
                                    <div class="col-md-4 col-12 ">
                                        <input type="radio" name="packages_id" value="{{$year->id}}" class=" d-none"
                                               id="package_id_{{$year->id}}">
                                        <div class="card-package card-package">
                                            <div class="package-top">
                                                <div class="type-name">{{$year->name}}</div>
                                                <div class="type-fee mb-5">
                                                    {{$year->price}} TL
                                                    <span class="type-fee-info month-tr"> / AYDA </span>
                                                </div>

                                                <div class="col-12 text-center">
                                                    <button type="button"
                                                            class="btn btn-bold btn-block btn-primary select_radio"
                                                            data-summarytext="2" data-price="{{$year->price}}₺"
                                                            data-name="{{$year->name}}" data-id="{{$year->id}}">Üyelik
                                                        Paketi Seç
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="package-bottom">
                                                <ul>
                                                    @if(!empty($year->detils))
                                                        @foreach($year->detils as $detail)
                                                            <li><i class="fa fa-check"></i> {{$detail->description}}
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <div class="step-3 d-none">
                <span class="step-title">
                    KİŞİSEL BİLGİLERİNİ GİR
                </span>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-7 col-12">
                                <div class="information-tab" style="padding-bottom: 50px;padding-top: 50px;">
                                    <div class="form-group">
                                        <input type="username" value="" class="form-control username" required=""
                                               id="username"
                                               name="username">
                                        <label for="username">{{__('auth.username')}}</label>
                                    </div>
                                    <div class="form-group ">
                                        <input type="password" value="" class="form-control password" required=""
                                               id="password"
                                               name="password">
                                        <label for="password">{{__('auth.passwords')}}</label>
                                    </div>
                                    <div class="form-group ">
                                        <input type="email" value="" class="form-control email" required="" id="email"
                                               name="email">
                                        <label for="email">{{__('auth.email')}}</label>
                                    </div>
                                    <div class="form-group ">
                                        <input type="number" value="" class="form-control tc" required="" id="tc"
                                               name="tc">
                                        <label for="tc">{{__('auth.tc')}}</label>
                                    </div>
                                    <div class="form-group ">
                                        <select name="gender" class="form-control" id="gender"
                                                style="padding-top: 0px !important;">
                                            <option value="">Lütfen Seçim Yapınız</option>
                                            <option value="1">{{__('auth.male')}}</option>
                                            <option value="2">{{__('auth.female')}}</option>
                                        </select>
                                    </div>
                                    <div class="form-group mb-1">
                                        <input type="date" value="" class="form-control birthday" required=""
                                               id="birthday"
                                               name="birthday">
                                        <label for="email">{{__('auth.birthday')}}</label>
                                    </div>
                                    <span style="font-family: Roboto, sans-serif !important;
                                    font-weight: 400;
                                    font-stretch: normal;
                                    font-style: normal;
                                    line-height: 1.5;
                                    letter-spacing: normal;
                                    -webkit-box-pack: start;
                                    -ms-flex-pack: start;
                                    justify-content: flex-start;
                                    color: #65666a;">Kulüp üyeliğinde yaş sınırı bulunmaktadır.</span>
                                </div>
                            </div>
                            <div class="col-md-5 col-12" class="information-tab">
                                <div class="summary px-20 pt-10 pb-10">
                                    <div class="summary-content">
                                        <div class="title">Seçtiğiniz Paket <span class="edit" onclick="step_change(2)">Düzenle</span>
                                        </div>
                                        <div class="package">Gold - Yıllık</div>
                                        <div class="price">2359 TL / Ay</div>
                                        <div class="discount_text">PEŞİN ÖDEMEDE EKSTRA İNDİRİM</div>
                                    </div>
                                    <div class="summary-button">
                                        <button type="button" class="btn btn-bold btn-block btn-primary mt-3 mb-3"
                                                onclick="step_change(4)" id="next_step_2">Üyelik
                                            Ödeme Ekranına Geç
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="step-4 d-none">
                <span class="step-title">
                    Ödeme Bilgileri
                </span>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-7 col-12">
                                <h5 class="text-black text-bold">KART BİLGİLERİNİ GİRİNİZ</h5>
                                <div class="information-tab" style="padding-bottom: 50px;padding-top: 50px;">

                                    <div class="form-group">
                                        <input type="text" value="" class="form-control cc_owner" required=""
                                               onchange="card_change_check()" id="cc_owner"
                                               name="cc_owner">
                                        <label for="cc_owner">{{__('auth.cc_owner')}}</label>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" value="" class="form-control card_number" required=""
                                               onchange="card_change_check()" id="card_number"
                                               name="card_number">
                                        <label for="card_number">{{__('auth.card_number')}}</label>
                                    </div>
                                    <div class="form-group">

                                        <label for="">{{__('auth.expiry_month')}}</label>
                                        <select name="expiry_month" id="expiry_month" onchange="card_change_check()"
                                                class="form-control">
                                            <option value="1">Ocak</option>
                                            <option value="2">Şubat</option>
                                            <option value="3">Mart</option>
                                            <option value="4">Nisan</option>
                                            <option value="5">Mayıs</option>
                                            <option value="6">Haziran</option>
                                            <option value="7">Temmuz</option>
                                            <option value="8">Ağustos</option>
                                            <option value="9">Eylül</option>
                                            <option value="10">Ekim</option>
                                            <option value="11">Kasım</option>
                                            <option value="12">Aralık</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">{{__('auth.expiry_year')}}</label>
                                        <select name="expiry_year" id="expiry_year" onchange="card_change_check()"
                                                class="form-control">
                                            @php
                                                $currentYear = date('Y'); // Mevcut yılı al
                                                $endYear = $currentYear + 10; // 10 yıl sonrasını hesapla
                                            @endphp
                                            @for($i = $currentYear; $i <= $endYear; $i++)
                                                <option value="{{ str_replace('20','',$i) }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="number" class="form-control" onchange="card_change_check()"
                                               name="cvv" id="cvv">
                                        <label for="cvv">{{__('auth.cvv')}}</label>
                                    </div>
                                </div>
                                <h5 class="text-black text-bold mt-3">SÖZLEŞMELERİ ONAYLAYINIZ</h5>
                                <div class="information-tab px-20 mt-3" style="padding-bottom: 50px;padding-top: 50px;">
                                    <div class="year-agreement d-none">
                                        <center><h4 class="text-black text-bold">12 Ay Kalma Sözüne</h4></center>
                                        <ul>
                                            <li>Taahhüt sürenin sonuna geldiğinde, iptal talebinde bulunmaz ya da üyelik
                                                yenilemesi yapmazsan, seçmiş olduğun taahhütlü üyeliğin o günkü
                                                fiyatıyla aylık esnek üyelik olarak yenilenecektir.
                                            </li>
                                            <li>Üyelik sürenin sonu itibariyle üyeliğine devam etmek istemezsen,
                                                üyeliğinin son ayında Fitcity aplikasyonu üzerinden veya
                                                portal.macfit.com.tr adresinden üye girişi yaparak iptal talebini
                                                iletebilir ve ek ücret ödemeden üyeliğini sonlandırabilirsin.
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="month-agreement d-none">
                                        <center><h4 class="text-black text-bold">Kalma Sözü Olmadan(Aylık)</h4></center>
                                        <ul>
                                            <li>Aylık ödemeli esnek üyelikler, üye tarafından iptal edilmediği sürece
                                                devam eder. Her ay üye olduğun günden bir gün önce, bir sonraki ayın
                                                ücreti kredi kartından tahsil edilecektir.
                                            </li>
                                            <li>Kulübünün yeni üyeler için geçerli olan fiyatları değiştiğinde,
                                                kullanmakta olduğun aylık esnek üyeliğin ücreti de bu doğrultuda
                                                güncellenecektir.
                                            </li>
                                            <li>Üyelikten ayrılmak istersen; ilk üye olduğun günden 2 gün öncesine kadar
                                                Fitcity aplikasyonu üzerinden veya portal.macfit.com.tr adresinden üye
                                                girişi yaparak iptal talebini iletebilir ve ek ücret ödemeden üyeliğini
                                                sonlandırabilirsin.
                                            </li>
                                        </ul>
                                    </div>
                                    <p>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="subscription_agreement"
                                               class="custom-control-input" id="subscription_agreement"
                                               onchange="card_change_check()">
                                        <label for="subscription_agreement" class="custom-control-label">

                                            ABONELİK SÖZLEŞMESİNİ , TAAHHÜTNAMEYİ , MESAFELİ SATIŞ SÖZLEŞMESİNİ , ÖN
                                            BİLGİLENDİRME FORMUNU OKUDUM, ONAYLIYORUM
                                        </label>
                                    </div>
                                    </p>
                                    <p>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="kvkk" id="kvkk" onchange="card_change_check()">
                                        <label for="kvkk" class="custom-control-label">
                                            KVKK KAPSAMINDA KİŞİSEL VERİLERİMİN İŞLENMESİNE AÇIK RIZA VERİYORUM.
                                        </label>
                                    </div>

                                    </p>
                                    <p>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="do_sport" id="do_sport"
                                               onchange="card_change_check()">
                                        <label for="do_sport" class="custom-control-label">

                                            SPOR YAPMAMDA SAĞLIKLA İLGİLİ BİR SORUNUM OLMADIĞINI BEYAN EDERİM.
                                        </label>
                                    </div>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-5 col-12" class="information-tab">
                                <div class="summary px-20 pt-10 pb-10">
                                    <div class="summary-content">
                                        <div class="title">Seçtiğiniz Paket <span class="edit" onclick="step_change(2)">Düzenle</span>
                                        </div>
                                        <div class="package">Gold - Yıllık</div>
                                        <div class="price">2359 TL / Ay</div>
                                        <div class="discount_text">PEŞİN ÖDEMEDE EKSTRA İNDİRİM</div>
                                    </div>
                                    <div class="summary-content mt-1">
                                        <div class="title">Üyelik Başlangıç Tarihi</div>
                                        <div class="date">{{date('d.m.Y')}}</div>
                                    </div>
                                    <div class="summary-button">
                                        <button type="submit"
                                                class="btn btn-bold btn-block btn-primary mt-3 mb-3 payment_button"
                                                disabled="">
                                            Ödemeyi Tamamla
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </form>


            <div class="modal fade" id="sanal_dcard_modal" tabindex="-1" role="dialog" aria-labelledby="3dcard_modal"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body sanaldmodalbody">

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>


<footer class="col-12 align-self-end text-center fs-13">
    <p class="mb-0"><small>Copyright © 2019 <a href="https://mockupsoft.com/">Mockup Soft</a>. All rights
            reserved.</small></p>
</footer>
</div>
</body>

<!-- Scripts -->


<script src="{{asset('panel/assets/js/core.min.js')}}"></script>
<script src="{{asset('panel/assets/js/app.min.js')}}"></script>
<script src="{{asset('panel/assets/js/script.js')}}"></script>
<script src="{{asset('panel/assets/js/toastify.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/authentication/signin.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset('panel/assets/js/imask.js')}}"></script>
<script>
    function card_change_check() {
        var cc_owner = $('#cc_owner').val();
        var card_number = $('#card_number').val();
        var expiry_month = $('#expiry_month').val();
        var cvv = $('#cvv').val();
        var subscription_agreement = $('#subscription_agreement').is(':checked') ? 1 : 2;
        var kvkk = $('#kvkk').is(':checked') ? 1 : 2;
        var do_sport = $('#do_sport').is(':checked') ? 1 : 2;
        if (cc_owner != '' && card_number != '' && expiry_month != '' && cvv != '' && subscription_agreement != 2 && kvkk != 2 && do_sport != 2) {
            $('.payment_button').removeAttr('disabled')
        } else {
            $('.payment_button').attr('disabled', '')
        }


    }

    var selectPackage = {
        id: '',
        name: '',
        price: '',
    };
    $('.step-button .year').click(function () {
        $(this).addClass('span-active')
        $('.step-button .month').removeClass('span-active')
        $('.step-content-year').removeClass('d-none');
        $('.step-content-month').addClass('d-none');
    })
    $('.step-button .month').click(function () {
        $(this).addClass('span-active')
        $('.step-button .year').removeClass('span-active')
        $('.step-content-year').addClass('d-none');
        $('.step-content-month').removeClass('d-none');
    })
    $('#next_step_2').click(function () {
        var telephone = $('#telephone').val();
        if (telephone != '') {
            $('.loader_body').show();
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            $.ajax({
                type: 'POST',
                url: '{{route('getCustomerPhoneCheck')}}',
                data : {telephone:telephone},
                success: function (data) {
                    if(data.type == 'false'){
                        step_change(2)
                        $('.loader-body').hide();
                    }else{
                        Toastify({
                            title:"Error",
                            text: "Hesabınız Mevcut. Girişe Yönlendiriliyorsunuz.",
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();
                        setTimeout(function(){
                            window.location.href = data.route_url;
                        }, 2000);

                    }


                },
                error: function(data)
                {
                    Toastify({
                        title:"Error",
                        text: "An Error Occurred, please try again later.",
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();

                    $('.loader-body').hide();
                }

            });

        } else {
            Toastify({
                title: "Error",
                text: 'Telefon Numarası Boş Olamaz.',
                style: {
                    background: "red",
                },
                offset: {
                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                    y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                },
            }).showToast();
        }

    })

    $('.select_radio').click(function () {
        var id = $(this).attr('data-id');
        var summary_text = $(this).attr('data-summarytext');
        var price = $(this).attr('data-price');
        var name = $(this).attr('data-name');
        $('#package_id_' + id).prop('checked', true);
        change_package(summary_text, price, name)
        step_change(3)

    })

    function change_package(summary_text, price, name) {
        $('.package').html(name)
        $('.price').html(price)
        if (summary_text == 1) {
            $('.discount_text').removeClass('d-none')
            $('.month-agreement').addClass('d-none')
            $('.year-agreement').removeClass('d-none')
        } else {
            $('.discount_text').addClass('d-none')
            $('.month-agreement').removeClass('d-none')
            $('.year-agreement').addClass('d-none')
        }
    }

    function step_change(step) {
        if (step == 1) {
            $('.logo-content').addClass('col-md-12')
            $('.breamcrub-content').addClass('d-none')
            $('.breamcrub-content').removeClass('col-md-8')
            $('.active').removeClass('active')
            $('.step-1').removeClass('d-none');
            $('.step-2').removeClass('d-none');
            $('.step-3').addClass('d-none');
            $('.step-4').addClass('d-none');
        }
        if (step == 2) {
            $('.logo-content').removeClass('col-md-12')
            $('.breamcrub-content').removeClass('d-none')
            $('.breamcrub-content').addClass('col-md-8')
            $('.active').removeClass('active')
            $('.user_type').addClass('active')
            $('.step-1').addClass('d-none');
            $('.step-2').removeClass('d-none');
            $('.step-3').addClass('d-none');
            $('.step-4').addClass('d-none');
        }
        if (step == 3) {
            $('.logo-content').removeClass('col-md-12')
            $('.breamcrub-content').removeClass('d-none')
            $('.breamcrub-content').addClass('col-md-8')
            $('.active').removeClass('active')
            $('.membership_info').addClass('active')
            $('.step-1').addClass('d-none');
            $('.step-2').addClass('d-none');
            $('.step-3').removeClass('d-none');
            $('.step-4').addClass('d-none');
        }
        if (step == 4) {
            var username = $('#username').val();
            var password = $('#password').val();
            var email = $('#email').val();
            var tc = $('#tc').val();
            var gender = $('#gender').val();
            var birthday = $('#birthday').val();
            if (username == '' || password == '' || email == '' || tc == '' || gender == '' || birthday == '') {
                Toastify({
                    title: "Error",
                    text: 'Lütfen Tüm Alanları Doldurunuz.',
                    style: {
                        background: "red",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();
            } else {
                $('.logo-content').removeClass('col-md-12')
                $('.breamcrub-content').removeClass('d-none')
                $('.breamcrub-content').addClass('col-md-8')

                $('.active').removeClass('active')
                $('.payment').addClass('active')
                $('.step-1').addClass('d-none');
                $('.step-2').addClass('d-none');
                $('.step-3').addClass('d-none');
                $('.step-4').removeClass('d-none');
            }

        }
    }

    $(document).ready(function () {
        if (document.querySelectorAll('.telephone')) {
            console.log(document.querySelectorAll('.telephone'));
            document.querySelectorAll('.telephone').forEach(function (item, index) {
                IMask(item, {mask: '(000) 000 0000'});
            })
        }
    })
</script>
