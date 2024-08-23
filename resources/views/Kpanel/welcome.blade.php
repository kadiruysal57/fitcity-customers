@extends('Kpanel.layouts.app')

@section('page-title') Ana Sayfa @endsection <!-- Sayfa title'ı ayarlanıyor -->

@section('CssContent')
    <style>
        .add_guest {
            cursor: pointer;
        }
        .add_guest p {
            color: #33cabb;
        }
        .add_guest:hover p {
            color: #4d5259;
        }
        .add_guest p img {
            filter: brightness(0) saturate(100%) invert(66%) sepia(59%) saturate(493%) hue-rotate(124deg) brightness(92%) contrast(86%);
        }
        .add_guest:hover p img {
            filter: brightness(0) saturate(100%) invert(31%) sepia(7%) saturate(515%) hue-rotate(175deg) brightness(98%) contrast(95%);
        }
        .add_credit {
            cursor: pointer;
        }
        .add_credit p {
            color: #33cabb;
        }
        .add_credit:hover p {
            color: #4d5259;
        }
        .add_credit p img {
            filter: brightness(0) saturate(100%) invert(66%) sepia(59%) saturate(493%) hue-rotate(124deg) brightness(92%) contrast(86%);
        }
        .add_credit:hover p img {
            filter: brightness(0) saturate(100%) invert(31%) sepia(7%) saturate(515%) hue-rotate(175deg) brightness(98%) contrast(95%);
        }
        .send_sms {
            cursor: pointer;
        }
        .send_sms p {
            color: #33cabb;
        }
        .send_sms:hover p {
            color: #4d5259;
        }
        .send_sms p img {
            filter: brightness(0) saturate(100%) invert(66%) sepia(59%) saturate(493%) hue-rotate(124deg) brightness(92%) contrast(86%);
        }
        .send_sms:hover p img {
            filter: brightness(0) saturate(100%) invert(31%) sepia(7%) saturate(515%) hue-rotate(175deg) brightness(98%) contrast(95%);
        }
        .send_phone {
            border: 1px solid #dedede;
            height: 120px;
            overflow-y: auto;
        }
        .send_phone ul li {
            border-bottom: 1px solid #dedede;
        }
        .box-items div {
            padding-right: 5px;
            padding-left: 5px;
        }
        .card {
            margin-bottom: 1rem;
        }
        .card-body {
            padding: 0.7rem 0.3rem;
        }
        .send_phone ul li {
            padding: 5px;
        }

        @media (max-width: 767px) {
            .box-items .col-lg-6, .box-items .col-lg-4, .box-items .col-lg-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="row">
            <div class="col-md-12">
                <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-9 col-lg-7 col-md-6 col-sm-12 mb-sm-0 mb-4">
                                            <div class="text-justified align-items-center">
                                                <h3 class="text-dark fw-semibold mb-2 mt-0">Merhaba, Hoşgeldiniz. <span class="text-primary">{{Auth::user()->name}}!</span></h3>
                                                @if(!empty(Auth::user()->getPackage))
                                                    @if(!empty(Auth::user()->getPackage->package->contracts_type) && Auth::user()->getPackage->package->contracts_type == 1)
                                                        <p class="text-dark fs-14 mb-3 lh-3">Yıllık plana geçerek %{{getUpDiscountRate()}}'a varan tasarruf sağlayabilirsiniz.</p>
                                                        <a href="{{route('MembershipInformation')}}" class="btn btn-primary shadow">Hemen Yükselt</a>
                                                    @else
                                                        <p class="text-dark fs-14 mb-3 lh-3">Yıllık plana kullanarak %{{Auth::user()->getPackage->package->discount_rate}} tasarruf sağladınız.</p>
                                                    @endif
                                                @else
                                                    <p class="text-dark fs-14 mb-3 lh-3">Yıllık plana geçerek %{{getUpDiscountRate()}}'a varan tasarruf sağlayabilirsiniz.</p>
                                                    <a href="{{route('MembershipInformation')}}" class="btn btn-primary shadow">Hemen Satın Al</a>

                                                @endif


                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                            <div class="card sales-card">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="ps-4 pt-4 pe-3 pb-4">
                                            <div class="">
                                                <span class="mb-2 fs-12 fw-semibold d-block">Mevcut Paket</span>
                                            </div>
                                            <div class="pb-0 mt-0">
                                                <div class="d-flex">
                                                    @if(!empty(Auth::user()->getPackage))
                                                        <h4 class="fs-20 fw-semibold mb-2">{{\Illuminate\Support\Facades\Auth::user()->getPackage->package->name}} @if(\Illuminate\Support\Facades\Auth::user()->getPackage->package->contracts_type == 2) Yıllık @endif </h4>
                                                    @else

                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
                                            <i class="fe fe-shopping-bag fs-16 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                            <div class="card sales-card">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="ps-4 pt-4 pe-3 pb-4">
                                            <div class="">
                                                <span class="mb-2 fs-12 fw-semibold d-block">Toplam Salon Girişi</span>
                                            </div>
                                            <div class="pb-0 mt-0">
                                                <div class="d-flex">
                                                    <h4 class="fs-20 fw-semibold mb-2">{{totalHallEntry()}}</h4>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
                                            <i class="fe fe-shopping-bag fs-16 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                            <div class="card sales-card">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="ps-4 pt-4 pe-3 pb-4">
                                            <div class="">
                                                <span class="mb-2 fs-12 fw-semibold d-block">Toplam Sipariş</span>
                                            </div>
                                            <div class="pb-0 mt-0">
                                                <div class="d-flex">
                                                    <h4 class="fs-20 fw-semibold mb-2">{{getOrderCount()}}</h4>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
                                            <i class="fe fe-shopping-bag fs-16 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                            <div class="card sales-card">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="ps-4 pt-4 pe-3 pb-4">
                                            <div class="">
                                                <span class="mb-2 fs-12 fw-semibold d-block">Toplam Üyelik Siparişi</span>
                                            </div>
                                            <div class="pb-0 mt-0">
                                                <div class="d-flex">
                                                    <h4 class="fs-20 fw-semibold mb-2">{{getOrderCount(2)}}</h4>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="circle-icon bg-info-transparent text-center align-self-center overflow-hidden">
                                            <i class="fe fe-shopping-bag fs-16 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                            <div class="card sales-card">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="ps-4 pt-4 pe-3 pb-4">
                                            <div class="">
                                                <span class="mb-2 fs-12 fw-semibold d-block">Toplam Ürün Siparişi</span>
                                            </div>
                                            <div class="pb-0 mt-0">
                                                <div class="d-flex">
                                                    <h4 class="fs-20 fw-semibold mb-2">{{getOrderCount(3)}}</h4>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
                                            <i class="fe fe-shopping-bag fs-16 text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                            <div class="card sales-card">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="ps-4 pt-4 pe-3 pb-4">
                                            <div class="">
                                                <span class="mb-2 fs-12 fw-semibold d-block">Abonelik Başlangıcı'ndan itibaren geçen gün sayısı</span>
                                            </div>
                                            <div class="pb-0 mt-0">
                                                <div class="d-flex">
                                                    <h4 class="fs-20 fw-semibold mb-2">{{getOrderStartDateDiff()}}</h4>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="circle-icon bg-warning-transparent text-center align-self-center overflow-hidden">
                                            <i class="fe fe-clock fs-16 text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('JsContent')
    <script src="{{ asset('panel/assets/js/dashboard/dashboard.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            @if(isset($_GET['modal']))
            $('#{{ $_GET['modal'] }}').modal('show');
            @endif
        });


    </script>
@endsection
