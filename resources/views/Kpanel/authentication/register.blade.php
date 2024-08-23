<html lang="en">
<link type="text/css" rel="stylesheet" id="dark-mode-custom-link">
<link type="text/css" rel="stylesheet" id="dark-mode-general-link">
<style lang="en" type="text/css" id="dark-mode-custom-style"></style>
<style lang="en" type="text/css" id="dark-mode-native-style"></style>
<style lang="en" type="text/css" id="dark-mode-native-sheet"></style>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive admin dashboard and web application ui kit. ">
    <meta name="keywords" content="login, signin">

    <title>Eva Gym Kayıt Ol</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,300i" rel="stylesheet">

    <!-- Styles -->
    <link id="style" href="{{asset('nowa-panel/assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <link href="{{asset('panel/assets/css/core.min.css')}}" rel="stylesheet">
    <link href="{{asset('panel/assets/css/app.min.css')}}" rel="stylesheet">
    <link href="{{asset('panel/assets/css/style.css')}}" rel="stylesheet">
    <link href="{{asset('nowa-panel/assets/css/register.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="{{asset("panel/assets/css/toastify.css")}}" type="text/css"/>

    <!-- Favicons -->
    <link rel="icon" href="{{asset('nowa-panel/assets/images/eva-favicon.png')}}">
    <link rel="icon" href="{{asset('nowa-panel/assets/images/eva-favicon.png')}}">

    <style type="text/css">
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <style>


    </style>
</head>

<body class="  pace-done">

<header>
    <div class="text-center logo-content col-md-12 ">
        <a href="/">
            <img src="{{asset('/nowa-panel/assets/images/logo.png')}}" alt="">
        </a>
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
<div class="preloader loader" style="display: block;">
    <div class="spinner-dots spinner-dots min-h-fullscreen center-vh mx-auto">
        <span class="dot1"></span>
        <span class="dot2"></span>
        <span class="dot3"></span>
    </div>
</div>

<div class="row min-h-fullscreen p-20 m-0" style="padding: 0px!important;">

    <div class="col-12 ">


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

                                <input type="tel" id="telephone" class="telephone" name="telephone"
                                       placeholder="(5xx) xxx-xxxx">
                            </div>


                            <div class="form-group border-none">
                                <button type="button" class="btn btn-bold btn-block btn-primary" id="next_step_2">Üyelik
                                    Paketlerini Gör
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center text-black">
                        Kişisel verileriniz <a href="#" class="text-bold" onclick="getContract(2)">Aydınlatma Metni</a>
                        kapsamında işlenmektedir.
                    </div>
                </div>
                <div class="step-2 d-none">
                <span class="step-title">
                    Kendine en uygun <br> üyelik paketini seç
                </span>

                    <div class="step-content">
                        <div class="row">
                            @foreach($all_packages as $year)
                                <div class="col-md-4 col-12 ">
                                    <input type="radio" name="packages_id" value="{{$year->id}}" class="d-none"
                                           id="package_id_{{$year->id}}">
                                    <div class="card-package card-package">
                                        <div class="package-top">
                                            <div class="type-name">{{$year->name}}</div>
                                            @if($year->discount_rate > 0)
                                                <div class="type-fee">
                                                    {{$year->discount_price}} TL
                                                    <span class="type-fee-info month-tr"> @if($year->contracts_type != 3) / AYDA @else / <YILDA></YILDA> @endif </span>
                                                </div>
                                                <div class="type-fee old-price">
                                                    {{$year->price}} TL
                                                </div>
                                            @else
                                                <div class="type-fee">
                                                    {{$year->discount_price}} TL
                                                    <span class="type-fee-info month-tr"> @if($year->contracts_type != 3) / AYDA @else / <YILDA></YILDA> @endif </span>
                                                </div>

                                            @endif
                                            @if($year->contracts_type == 2)
                                            <div class="type-extra">
                                                1 Yıl Kalma Sözüne {{$year->discount_rate}}% İndirim
                                            </div>
                                            @elseif($year->contracts_type == 3)
                                                <div class="type-extra">
                                                    1 Yıl Peşin Ödemeye {{$year->discount_rate}}% İndirim
                                                </div>
                                            @endif
                                            <div class="col-12 text-center">
                                                <button type="button"
                                                        class="btn btn-bold btn-block btn-primary select_radio"
                                                        data-summarytext="{{$year->contracts_type}}"
                                                        data-price="{{$year->discount_price}} TL/AYDA"
                                                        data-notdiscount="{{$year->price}} TL/AYDA"
                                                        data-name="{{$year->name}} - Yıllık"
                                                        data-id="{{$year->id}}"
                                                        data-gender="{{$year->gender_discount}}"
                                                        data-discount="{{$year->gender_discount_price}}"
                                                        data-discountrate="{{$year->gender_discount_rate}}">Üyelik
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
                <div class="step-3 d-none">
                <span class="step-title">
                    KİŞİSEL BİLGİLERİNİ GİR
                </span>
                    <div class="col-12">
                        <div class="row">

                            <div class="col-md-7 col-12">
                                <div class="information-tab " style="padding-bottom: 50px;padding-top: 50px;">
                                    <div class="input-group">
                                        <input type="text" value="" class="form-control username"
                                               placeholder="{{__('auth.username')}}" required=""
                                               id="username"
                                               name="username">
                                    </div>
                                    <div class="input-group ">
                                        <input type="password" value="" class="form-control password"
                                               placeholder="{{__('auth.passwords')}}" required=""
                                               id="password"
                                               name="password">
                                    </div>
                                    <div class="input-group ">
                                        <input type="email" value="" class="form-control email"
                                               placeholder="{{__('auth.email')}}" required="" id="email"
                                               name="email">
                                    </div>
                                    <div class="input-group ">
                                        <input type="number" value="" class="form-control tc"
                                               placeholder="{{__('auth.tc')}}" required="" id="tc"
                                               name="tc">
                                    </div>
                                    <div class="input-group ">
                                        <select name="gender" class="form-control" id="gender"
                                                style="    padding-top: 3px !important;
    padding-bottom: 3px;">
                                            <option value="">Lütfen Seçim Yapınız</option>
                                            <option value="1">{{__('auth.male')}}</option>
                                            <option value="2">{{__('auth.female')}}</option>
                                        </select>
                                    </div>
                                    <div class="input-group mb-1">
                                        <input type="date" value="" class="form-control birthday"
                                               placeholder="{{__('auth.birthday')}}" required=""
                                               id="birthday"
                                               name="birthday">
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

                                    <div class="input-group mb-1">
                                        <select name="city_id" class="form-control" id="city_id">
                                            <option value="">Lütfen Şehir Seçiniz.</option>
                                            @foreach($cities as $c)
                                                <option value="{{$c->id}}">{{$c->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="input-group mb-1">
                                        <select name="counties_id" class="form-control" id="counties_id">
                                            <option value="">Lütfen İlçe Seçiniz.</option>
                                        </select>
                                    </div>

                                    <div class="input-group ">
                                        <input type="text" value="" class="form-control"
                                               placeholder="{{__('auth.semt')}}" required="" id="semt"
                                               name="semt">
                                    </div>

                                    <div class="input-group ">
                                        <input type="text" value="" class="form-control"
                                               placeholder="{{__('auth.mahalle')}}" required="" id="mahalle"
                                               name="mahalle">
                                    </div>

                                    <div class="input-group ">
                                        <textarea name="adres" id="adres" class="form-control" placeholder="{{__('auth.adres')}}"></textarea>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5 col-12" class="information-tab">
                                <div class="summary px-20 pt-10 pb-10" style="margin-right: 0px !important;">
                                    <div class="summary-content">
                                        <div class="title">Seçtiğiniz Paket <span class="edit" onclick="step_change(2)">Düzenle</span>
                                        </div>
                                        <div class="package">Gold - Yıllık</div>
                                        <div class="price">2359 TL / Ay</div>
                                        <div class="discount_price">2359 TL / Ay</div>
                                        <div class="discount_text">1 YIL KALMA SÖZÜNE EKSTRA İNDİRİM</div>
                                        <div class="discount_text2">PEŞİN ÖDEMEDE EKSTRA İNDİRİM</div>
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
                                <div class="information-tab " style="padding-bottom: 50px;padding-top: 50px;">

                                    <div class="input-group">
                                        <input type="text" value="" class="form-control cc_owner"
                                               placeholder="{{__('auth.cc_owner')}}" required=""
                                               onchange="card_change_check()" id="cc_owner"
                                               name="cc_owner">
                                    </div>
                                    <div class="input-group">
                                        <input type="number" value="" class="form-control card_number"
                                               placeholder="{{__('auth.card_number')}}" required=""
                                               onchange="card_change_check()" id="card_number"
                                               name="card_number">
                                    </div>
                                    <div class="input-group">

                                        <select name="expiry_month" id="expiry_month" onchange="card_change_check()"
                                                class="form-control">
                                            <option value="">{{__('auth.expiry_month')}}</option>
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
                                    <div class="input-group">
                                        <select name="expiry_year" id="expiry_year" onchange="card_change_check()"
                                                class="form-control">
                                            <option value="">{{__('auth.expiry_year')}}</option>
                                            @php
                                                $currentYear = date('Y'); // Mevcut yılı al
                                                $endYear = $currentYear + 10; // 10 yıl sonrasını hesapla
                                            @endphp
                                            @for($i = $currentYear; $i <= $endYear; $i++)
                                                <option value="{{ str_replace('20','',$i) }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="{{__('auth.cvv')}}"
                                               onchange="card_change_check()"
                                               name="cvv" id="cvv">
                                    </div>
                                </div>
                                <h5 class="text-black text-bold mt-3">SÖZLEŞMELERİ ONAYLAYINIZ</h5>
                                <div class="information-tab  mt-3" style="padding-bottom: 50px;padding-top: 50px;">
                                    <div class="year-agreement d-none">
                                        <center><h4 class="text-black text-bold">12 Ay Kalma Sözüne</h4></center>
                                        <ul>
                                            <li>Taahhüt sürenin sonuna geldiğinde, iptal talebinde bulunmaz ya da üyelik
                                                yenilemesi yapmazsan, seçmiş olduğun taahhütlü üyeliğin o günkü
                                                fiyatıyla aylık esnek üyelik olarak yenilenecektir.
                                            </li>
                                            <li>Üyelik sürenin sonu itibariyle üyeliğine devam etmek istemezsen,
                                                üyeliğinin son ayında EVAGYM aplikasyonu üzerinden veya
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
                                                EVAGYM aplikasyonu üzerinden veya portal.macfit.com.tr adresinden üye
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

                                            <a href="#" onclick="getContract(3)" style="text-decoration: underline;">ABONELİK
                                                SÖZLEŞMESİNİ</a> , <a href="#"
                                                                      onclick="getContract(1)"
                                                                      style="text-decoration: underline;">TAAHHÜTNAMEYİ</a>
                                            , <a href="#" onclick="getContract(4)" style="text-decoration: underline;">MESAFELİ
                                                SATIŞ SÖZLEŞMESİNİ</a>
                                            OKUDUM, ONAYLIYORUM
                                        </label>
                                    </div>
                                    </p>
                                    <p>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="kvkk" id="kvkk"
                                               onchange="card_change_check()">
                                        <label for="kvkk" class="custom-control-label">
                                            <a href="#" onclick="getContract(2)" style="text-decoration: underline;">KVKK</a>
                                            KAPSAMINDA KİŞİSEL VERİLERİMİN
                                            İŞLENMESİNE AÇIK RIZA VERİYORUM.
                                        </label>
                                    </div>

                                    </p>
                                    <p>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="do_sport"
                                               id="do_sport"
                                               onchange="card_change_check()">
                                        <label for="do_sport" class="custom-control-label">

                                            SPOR YAPMAMDA SAĞLIKLA İLGİLİ BİR SORUNUM OLMADIĞINI BEYAN EDERİM.
                                        </label>
                                    </div>
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-5 col-12" class="information-tab">
                                <div class="summary px-20 pt-10 pb-10" style="margin-right: 0px!important;">
                                    <div class="summary-content">
                                        <div class="title">Seçtiğiniz Paket <span class="edit" onclick="step_change(2)">Düzenle</span>
                                        </div>
                                        <div class="package">Gold - Yıllık</div>
                                        <div class="price">2359 TL / Ay</div>
                                        <div class="discount_price">2359 TL / Ay</div>

                                        <div class="discount_text">1 YIL KALMA SÖZÜNE EKSTRA İNDİRİM</div>
                                        <div class="discount_text2">PEŞİN ÖDEMEDE EKSTRA İNDİRİM</div>
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

            <div class="modal fade" id="sanal_dcard_modal" data-backdrop="static" tabindex="-1" role="dialog"
                 aria-labelledby="staticBackdropLabel" aria-hidden="true" data-bs-backdrop="static"
                 data-bs-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body sanaldmodalbody">
                            <iframe id="sanaldmodalbodyIframe" style="width:100%; height:500px; border:none;"></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="getContractModal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-body getContractModal">
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary" data-dismiss="modal" onclick="modal_hide(getContractModal)">
                                Kapat
                            </button>
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
</body>

<!-- Scripts -->


<script src="{{asset('nowa-panel/assets/libs/@popperjs/core/umd/popper.min.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/jquery-3.6.1.min.js')}}"></script>

<script src="{{asset('nowa-panel/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


<script src="{{asset('panel/assets/js/core.min.js')}}"></script>
<script src="{{asset('panel/assets/js/app.min.js')}}"></script>
<script src="{{asset('panel/assets/js/script.js')}}"></script>
<script src="{{asset('panel/assets/js/toastify.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/authentication/signin.js')}}"></script>
<script src="{{asset('nowa-panel/assets/js/jquery-3.6.1.min.js')}}"></script>
<script src="{{asset('panel/assets/js/imask.js')}}"></script>
<script>
    let gender_global = null;
    let gender_discount_global = null;
    let gender_discountrate_global = null;

    function modal_hide(modal) {
        $(modal).modal('hide');
    }

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

    function getContract(contract_id) {
        var package_id = $('input[name="packages_id"]:checked').val();
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });
        $.ajax({

            type: 'POST',

            url: '{{route('getContractsCustomer')}}',

            data: {contract_id: contract_id, package_id: package_id},
            success: function (data) {
                if (data.type == "true") {
                    $('.getContractModal').html(data.contract_text);
                    $('#getContractModal').modal('show');
                } else {
                    Toastify({
                        title: "Error",
                        text: data.message,
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                }

            },
            error: function (data) {
                Toastify({
                    title: "Error",
                    text: "An Error Occurred, please try again later.",
                    style: {
                        background: "red",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();

                $('.loader').hide();
            }

        });
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
            $('.loader').show();
            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });
            $.ajax({
                type: 'POST',
                url: '{{route('getCustomerPhoneCheck')}}',
                data: {telephone: telephone},
                success: function (data) {
                    if (data.type == 'false') {

                        step_change(2)
                        $('.loader').hide();
                    } else {
                        Toastify({
                            title: "Error",
                            text: "Hesabınız Mevcut. Girişe Yönlendiriliyorsunuz.",
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();
                        setTimeout(function () {
                            window.location.href = data.route_url;
                        }, 2000);

                    }


                },
                error: function (data) {
                    Toastify({
                        title: "Error",
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
        var notdiscount = $(this).attr('data-notdiscount');
        var name = $(this).attr('data-name');
        var gender = $(this).attr('data-gender');
        var gender_discount = $(this).attr('data-discount');
        var gender_discountrate = $(this).attr('data-discountrate');
        gender_global = gender
        gender_discount_global = gender_discount
        gender_discountrate_global = gender_discountrate
        console.log(gender, gender_discount, gender_discountrate)
        $('#package_id_' + id).prop('checked', true);
        change_package(summary_text, price, notdiscount, name, gender, gender_discount, gender_discountrate)
        step_change(3)

    })

    function change_package(summary_text, price, notdiscount, name, gender = null, gender_discount = null, gender_discountrate = null) {
        $('.package').html(name)
        $('.price').html(price)
        $('.discount_price').html(notdiscount)
        if (summary_text == 1) {
            $('.discount_text').addClass('d-none')
            $('.discount_text2').addClass('d-none')
            $('.month-agreement').removeClass('d-none')
            $('.discount_price').addClass('d-none')
            $('.year-agreement').addClass('d-none')
        }else if(summary_text == 2){
            $('.discount_text').removeClass('d-none')
            $('.discount_text2').addClass('d-none')
            $('.month-agreement').addClass('d-none')
            $('.discount_price').addClass('d-none')
            $('.year-agreement').removeClass('d-none')
        } else {
            $('.discount_text').addClass('d-none')
            $('.discount_text2').removeClass('d-none')
            $('.month-agreement').addClass('d-none')
            $('.discount_price').removeClass('d-none')
            $('.year-agreement').removeClass('d-none')
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
            var city_id = $('#city_id').val();
            var counties_id = $('#counties_id').val();
            var semt = $('#semt').val();
            var mahalle = $('#mahalle').val();
            var adres = $('#adres').val();

            if (city_id == '' || counties_id == '' || semt == '' || mahalle == '' || adres == '' || username == '' || password == '' || email == '' || tc == '' || gender == '' || birthday == '') {
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
                var error = 2;
                var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

                if (tc.length !== 11) {
                    error = 1
                    Toastify({
                        title: "Error",
                        text: 'TC kimlik numarasının 11 haneli olduğundan emin olun.',
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                }
                if (!emailRegex.test(email)) {
                    error = 1
                    Toastify({
                        title: "Error",
                        text: 'Geçersiz bir e-posta adresi.',
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                }
                if (password.length < 6) {
                    error = 1;
                    Toastify({
                        title: "Error",
                        text: 'Şifre en az 6 karakter olmalıdır.',
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                        },
                    }).showToast();
                }


                if (error == 2) {
                    var gender = $('#gender').val();
                    if (gender == gender_global) {
                        $('.price').html(gender_discount_global + " TL/AYDA (Kadın Üyelerimize Özel Fiyat)")
                    }
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
    }

    $(document).ready(function () {
        if (document.querySelectorAll('.telephone')) {
            console.log(document.querySelectorAll('.telephone'));
            document.querySelectorAll('.telephone').forEach(function (item, index) {
                IMask(item, {mask: '(000) 000 0000'});
            })
        }
        $('#city_id').change(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{route('getCounties')}}',
                type: 'POST',
                data: {
                    city_id: $(this).val(),
                },
                success: function (response) {
                    if(response.type == "true"){
                        $('#counties_id').html(response.return_text);
                    }else{
                        Toastify({
                            title:"error",
                            text: "Bir Hata Oluştu Daha Sonra Tekrar Deneyiniz.",
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();
                    }
                    $('#loader').addClass('d-none');
                },
                error: function (xhr, status, error) {

                }
            });
        })

    })


</script>
