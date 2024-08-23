@extends('Kpanel.layouts.app')

@section('page-title')
    Üyelik Bilgileirm
@endsection
@section('CssContent')
@endsection

@section('content')

    <div class="main-content">
        <div class="col-12">
            <div class="card card-transparent mx-auto text-center">
                <div class="card" style="    border-bottom: none !important">
                    <div class="card-header">
                        <h3 class="card-title">Üyelik Bilgilerim</h3>
                    </div>
                    <div class="card-body">
                        @if(!empty($_GET['type']) && $_GET['type'] == 'error')
                            <div class="alert alert-danger">
                                <span>{{$_POST['fail_message']}}</span>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-12 col-md-12" style="margin-bottom: 20px;border-bottom:1px solid #dedede;padding-bottom: 20px;">
                                @if(count($user_package) == 0)
                                    <center><h5>Aktif Abonelik Mevcut Değil</h5></center>
                                @else
                                    <h4>Aboneliklerim</h4>
                                    <div class="row">
                                        @foreach($user_package as $p)
                                            <div class="package-card text-center col-md-4 col-12" >
                                                <div class="card-package card-package" style="margin: 0px;">
                                                    <div class="package-top">
                                                        <div class="type-name">{{$p->package->name}}</div>
                                                        @if($p->package->discount_rate > 0)
                                                            <div class="type-fee">
                                                                {{$p->discount_price}}₺
                                                                <span class="type-fee-info month-tr"> / AYDA </span>
                                                            </div>
                                                            <div class="type-fee old-price">
                                                                {{$p->price}}₺
                                                            </div>
                                                        @endif
                                                        @if(!empty($p->package_repeat) && $p->package_repeat->status != 2)
                                                            <p>Yenileme Tarihi : {{date('d.m.Y',strtotime($p->finish_date))}}</p>
                                                        @else
                                                            <p>Başlangıç Tarihi : {{date('d.m.Y',strtotime($p->start_date))}}</p>
                                                            <p>Bitiş Tarihi : {{date('d.m.Y',strtotime($p->finish_date))}}</p>
                                                        @endif
                                                        @if(!empty($p->package_repeat) && $p->package_repeat->status == 1)
                                                            <p class="text-success">Devam Ediyor</p>
                                                        @elseif(!empty($p->package_repeat) && $p->package_repeat->status == 2)
                                                            <p class="text-danger">İptal Edildi.</p>
                                                        @else
                                                            <p class="text-warning">Ödeme Alınamadı.</p>
                                                        @endif
                                                        @if($p->package->discount_rate > 0)
                                                            <p><smal><del>{{$p->price}}₺</del></smal> {{$p->discount_price}}₺</p>
                                                        @else
                                                            <p>{{$p->package->price}} ₺</p>
                                                        @endif
                                                        @if(!empty($p->package_repeat)  && $p->package_repeat->status == 2 && !empty($p->package_repeat->cancelled_price))
                                                            <p class="text-danger">İptal Etmek İçin Ödenene Miktar : {{$p->package_repeat->cancelled_price}} ₺</p>
                                                        @endif

                                                        <div class="col-12 text-center">
                                                            @if(!empty($p->package_repeat->status) && $p->package_repeat->status != 2)
                                                                <button type="button"  class="btn btn-danger cancelled_package" data-id="{{$p->id}}">İptal Et</button>
                                                            @endif

                                                        </div>
                                                    </div>
                                                    <div class="package-bottom">
                                                        <ul>
                                                            @foreach($p->package->detils as $detail)
                                                                <li><i class="fa fa-check"></i> {{$detail->description}}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="row">
                                    @foreach($year_packages as $year)
                                        <div class="package-card text-center col-md-4 col-12" >
                                            <div class="card-package card-package" style="margin: 0px">
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
                                                            class="btn btn-bold btn-block btn-primary BuyPackage"
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
                                    @foreach($month_packages as $year)
                                       <div class="package-card text-center col-md-4 col-12 mt-3" >
                                            <div class="card-package card-package" style="margin: 0px;">
                                                <div class="package-top">
                                                    <div class="type-name">{{$year->name}}</div>
                                                    <div class="type-fee mb-5">
                                                        {{$year->price}} TL
                                                        <span class="type-fee-info month-tr"> / AYDA </span>
                                                    </div>

                                                    <div class="col-12 text-center">
                                                        <button type="button"
                                                                class="btn btn-bold btn-block btn-primary BuyPackage"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addPackage" tabindex="-1" role="dialog" aria-labelledby="add_credit_card"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kart Ekle</h5>

                </div>
                <div class="modal-body">
                    <input type="hidden" name="package_id" id="package_id">
                    @php
                        $add_card_show = 2;
                    @endphp
                    @if(!empty($credits->save_card) && empty($credits->save_card->status))
                        <ul>
                            @foreach($credits->save_card as $key => $save_card)
                                @php
                                    $add_card_show = 1;
                                @endphp
                                <li><label for="{{$save_card->ctoken}}">
                                    <span><input type="radio" name="select_card" id="{{$save_card->ctoken}}" @if($key == 0) checked="" @endif value="{{$save_card->ctoken}}"></span>
                                    <span>{{$save_card->c_name}} /</span>
                                   <span>**** **** **** {{$save_card->last_4}} / </span>
                                    <span>{{$save_card->month}}/{{$save_card->year}} ({{$save_card->schema}})</span>
                                    </label>
                                </li>
                            @endforeach

                        </ul>
                    @else
                        <center><h5>Kart Bulunamadı.</h5>
                        <a href="{{route('CreditCardList',['return_url'=>route('MembershipInformation')])}}" class="btn btn-success"><i class="fa fa-credit-card"></i> Kart Ekle</a>
                        </center>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger cancel_modal" data-dismiss="modal">Vazgeç</button>
                    @if($add_card_show == 1)
                    <a href="{{route('CreditCardList',['return_url'=>route('MembershipInformation')])}}" class="btn btn-success"><i class="fa fa-credit-card"></i> Kart Ekle</a>
                    @endif
                    <button type="submit" class="btn btn-success " id="start_payment">Öde</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cancelledPackageCard" tabindex="-1" role="dialog" aria-labelledby="cancelledPackageCard"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Kart Ekle</h5>

                </div>
                <div class="modal-body">
                    <input type="hidden" name="cancelled_package_id" id="cancelled_package_id">
                    @php
                        $add_card_show = 2;
                    @endphp
                    @if(!empty($credits->save_card) && empty($credits->save_card->status))
                        <ul>
                            @foreach($credits->save_card as $key => $save_card)
                                @php
                                    $add_card_show = 1;
                                @endphp
                                <li><label for="{{$save_card->ctoken}}">
                                    <span><input type="radio" name="select_card_cancelled" id="{{$save_card->ctoken}}" @if($key == 0) checked="" @endif value="{{$save_card->ctoken}}"></span>
                                    <span>{{$save_card->c_name}} /</span>
                                   <span>**** **** **** {{$save_card->last_4}} / </span>
                                    <span>{{$save_card->month}}/{{$save_card->year}} ({{$save_card->schema}})</span>
                                    </label>
                                </li>
                            @endforeach

                        </ul>
                    @else
                        <center><h5>Kart Bulunamadı.</h5>
                        <a href="{{route('CreditCardList',['return_url'=>route('MembershipInformation')])}}" class="btn btn-success"><i class="fa fa-credit-card"></i> Kart Ekle</a>
                        </center>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger cancel_modal_cancelled_package" data-dismiss="modal">Vazgeç</button>
                    @if($add_card_show == 1)
                    <a href="{{route('CreditCardList',['return_url'=>route('MembershipInformation')])}}" class="btn btn-success"><i class="fa fa-credit-card"></i> Kart Ekle</a>
                    @endif
                    <button type="submit" class="btn btn-success " id="start_payment_cancelled">Öde</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sanal_dcard_modal" tabindex="-1" role="dialog" aria-labelledby="3dcard_modal"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body sanaldmodalbody">

                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="package_cancelled_modal" tabindex="-1" role="dialog" aria-labelledby="package_cancelled_modal"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body package_cancelled_modal">
                    <div class="table-responsive">
                        <table class="table table-separated ">
                            <thead class="text-center">
                                <th>Başlangıç Tarihi</th>
                                <th>Bitiş Tarihi</th>
                                <th>İndirimli Tutar</th>
                                <th>İndirimsiz Tutar</th>
                                <th>Ödenmesi Gereken Miktar</th>
                            </thead>
                            <tbody class="package_cancelled_modal_tbody text-center">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger cancel_modal_package" data-dismiss="modal">Vazgeç</button>

                    <button type="submit" class="btn btn-success " id="cancelled_package_payment">Öde Ve İptal Et</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('JsContent')
    <script>

        $(document).ready(function () {
            @if(!empty($_GET['membership_check']) && $_GET['membership_check'] == 1)
            var intervalTime = 5000; // 5 saniye
            var stopTime = 180000; // 3 dakika (180000 milisaniye)
            var intervalId = setInterval(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: '{{route('MembershipCheck')}}',
                    data: {},
                    success: function (data) {
                        if(data.type == "true"){
                            window.location.href = '{{route('MembershipInformation')}}';
                        }
                    },
                    error: function (data) {
                        Toastify({
                            title: "Error",
                            text: "Bir Hata Oluştu Daha Sonra Tekrar Deneyiniz.",
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50,
                                y: 10
                            },
                        }).showToast();

                        $('#loader').addClass('d-none');
                    }
                });
            }, intervalTime);

            // 3 dakika (180 saniye) sonra setInterval'i durdurun
            setTimeout(function() {
                clearInterval(intervalId);
            }, stopTime);
            @endif
            $('#cancelled_package_payment').click(function(){
                var cancelled_id = $(this).attr('data-id');
                $('#cancelled_package_id').val(cancelled_id);
                $('#package_cancelled_modal').modal('hide')
                $('#cancelledPackageCard').modal('show')
            })
            $('.cancelled_package').click(function(){
                var id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Aboneliği İptal Etmek İstediğinize Emin misiniz?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, İptal Et!',
                    cancelButtonText: 'Hayır',

                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#loader').removeClass('d-none');
                        $.ajaxSetup({

                            headers: {

                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                            }

                        });


                        $.ajax({

                            type: 'POST',

                            url: '{{route('MembershipCancelled')}}',

                            data: {id:id},
                            success: function (data) {
                                if(data.type=="true"){
                                    if(data.status == 1){
                                        Toastify({
                                            title: "success",
                                            text: "Abonelik İptal Edildi.",
                                            style: {
                                                background: "green",
                                            },
                                            offset: {
                                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                            },
                                        }).showToast();
                                    }else{
                                        $('.package_cancelled_modal_tbody').html(data.text);
                                        $('#cancelled_package_payment').attr('data-id',id)
                                        $('#package_cancelled_modal').modal('show');
                                    }
                                }else{
                                    Toastify({
                                        title: "Error",
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
                            error: function (data) {
                                Toastify({
                                    title: "Error",
                                    text: "Bir Hata Oluştu Daha Sonra Tekrar Deneyiniz.",
                                    style: {
                                        background: "red",
                                    },
                                    offset: {
                                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                    },
                                }).showToast();

                                $('#loader').addClass('d-none');
                            }

                        });
                    }
                });
            });
            $('.cancel_modal').click(function(){
                $('#addPackage').modal('hide');
            })
            $('.cancel_modal_package').click(function(){
                $('#package_cancelled_modal').modal('hide');
            })
            $('.cancel_modal_cancelled_package').click(function(){
                $('#cancelledPackageCard').modal('hide');
            })
            $('.BuyPackage').click(function(){
               var id = $(this).attr('data-id');
               $('#package_id').val(id);
               $('#addPackage').modal('show');
            });
            $('#start_payment').click(function () {
                $('#loader').removeClass('d-none');
                var package_id = $('#package_id').val();
                var ctoken = $('input[name="select_card"]:checked').val();

                if (package_id === '' || ctoken === '') {
                    Toastify({
                        title: "error",
                        text: "Kart Bilgilerini Kontrol Ediniz.",
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50,
                            y: 10
                        },
                    }).showToast();
                    $('#loader').addClass();
                } else {
                    $('#loader').removeClass('d-none');
                    $.ajaxSetup({

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        }

                    });
                    $.ajax({
                        url: '{{route('StartPaymentPackage')}}',
                        type: 'POST',
                        data: {
                            package_id: package_id,
                            ctoken: ctoken,
                        },
                        success: function (response) {


                            if(response.response === ''){
                                Toastify({
                                    title: "success",
                                    text: "Ödeme Başarılı. Yönlendiriliyorsunuz.",
                                    style: {
                                        background: "green",
                                    },
                                    offset: {
                                        x: 50,
                                        y: 10
                                    },
                                }).showToast();
                                $('#addPackage').modal('hide');
                                setTimeout(function(){
                                    location.reload();
                                }, 3000);

                            }else{
                                $('#sanal_dcard_modal').modal('show');
                                $('.sanaldmodalbody').html(response.response);
                            }
                        },
                        error: function (xhr, status, error) {
                            // Hata durumunda işlem
                            console.error(error);
                            $('#loader').addClass('d-none');
                        }
                    });
                }
            })
            $('#cancelled_package_payment').click(function () {
                $('#loader').removeClass('d-none');
                var cancelled_package_id = $('#cancelled_package_id').val();
                var ctoken = $('input[name="select_card_cancelled"]:checked').val();

                if (package_id === '' || ctoken === '') {
                    Toastify({
                        title: "error",
                        text: "Kart Bilgilerini Kontrol Ediniz.",
                        style: {
                            background: "red",
                        },
                        offset: {
                            x: 50,
                            y: 10
                        },
                    }).showToast();
                    $('#loader').addClass();
                } else {
                    $('#loader').removeClass('d-none');
                    $.ajaxSetup({

                        headers: {

                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                        }

                    });
                    $.ajax({
                        url: '{{route('StartPaymentCancelledPackage')}}',
                        type: 'POST',
                        data: {
                            cancelled_package_id: cancelled_package_id,
                            ctoken: ctoken,
                        },
                        success: function (response) {


                            if(response.response === ''){
                                Toastify({
                                    title: "success",
                                    text: "Ödeme Başarılı",
                                    style: {
                                        background: "green",
                                    },
                                    offset: {
                                        x: 50,
                                        y: 10
                                    },
                                }).showToast();
                                $('#addPackage').modal('hide');
                                setTimeout(function(){
                                    location.reload();
                                }, 3000);

                            }else{
                                $('#sanal_dcard_modal').modal('show');
                                $('.sanaldmodalbody').html(response.response);
                            }
                        },
                        error: function (xhr, status, error) {
                            // Hata durumunda işlem
                            console.error(error);
                            $('#loader').addClass('d-none');
                        }
                    });
                }
            })
        })
    </script>
@endsection
