
@extends('Kpanel.layouts.app')

@section('page-title')
    Ürünler
@endsection
@section('CssContent')

@endsection

@section('content')

    <div class="main-content">
        <div class="col-12">
            <div class="row">
                @if(count($basket) == 0)
                    <div class="card" style="box-shadow: 1px 1px 7px rgb(223 223 223);">
                        <center class="p-4">
                            <h3 class="text-center">Sepetinizde Ürün Bulunmamaktadır.</h3>
                            <a href="{{route('ProductsList')}}" class="btn btn-success col-4 text-center">Ürünlerimiz</a>
                        </center>
                    </div>
                @else
                    <form  method="post" action="{{route('StartPaymentBasket')}}" id="basket_pay">
                        <div class="card table-responsive" style="    box-shadow: 1px 1px 7px rgb(223 223 223);">
                            <table id="cart" class="table table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th style="width:50%">Ürün</th>
                                    <th style="width:10%">Fiyat</th>
                                    <th style="width:8%">Adet</th>
                                    <th style="width:22%" class="text-center">Toplam Fiyat</th>
                                    <th style="width:10%"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($basket as $b)
                                    @if($b->getProduct->getStockCheck() > 0)
                                        <tr class="basket_tr_{{$b->id}}">
                                            <td data-th="Product">
                                                <div class="row">
                                                    <div class="col-sm-2 hidden-xs"><img src="{{$b->getProduct->image_url}}" alt="..." class="img-responsive" /></div>
                                                    <div class="col-sm-10">
                                                        <h4 class="nomargin">{{$b->getProduct->name}}</h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td data-th="Price">{{number_format($b->price, 2, ',', '.')}}₺</td>
                                            <td data-th="Quantity">
                                                <input type="number" class="form-control text-center quantity_input" min="1" data-id="{{$b->id}}" value="{{$b->piece}}">
                                            </td>
                                            <td data-th="Subtotal" class="text-center subtotal_product_{{$b->id}}">{{number_format($b->total_price, 2, ',', '.')}}₺</td>
                                            <td class="actions" data-th="">
                                                <button class="btn btn-danger btn-sm deleteBasket" data-id="{{$b->id}}"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td><a href="{{route('ProductsList')}}" class="btn  q"><i class="fa fa-angle-left"></i> Alışverişe Devam Et</a></td>
                                    <td colspan="2" class="hidden-xs"></td>
                                    <td class="hidden-xs text-center"><strong>Toplam <span class="subtotal_basket">{{number_format($basket->sum('total_price'), 2, ',', '.')}}₺</span></strong></td>
                                    <td></td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                                <div class="card sales-card">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ps-4 pt-4 pe-3 pb-4">
                                                <div class="row">
                                                    <div class="col-lg-6 col-12"></div>
                                                    <span class="mb-2 fs-12 fw-semibold d-block">Teslimat Adresi</span>

                                                    <input type="hidden" name="delivery_address_id" value="{{\Illuminate\Support\Facades\Auth::user()->getAddressDelivery?->id ?? ''}}">
                                                    <div class="pb-0 mt-0">
                                                        <div class="row">
                                                            <div class="form-group col-md-6 col-12">
                                                                <label for="city_id_delivery">Şehir</label>
                                                                <select name="city_id_delivery" class="form-control" id="city_id_delivery" onchange="change_city('counties_id_delivery','city_id_delivery')">
                                                                    <option value="">Lütfen Seçim Yapınız</option>
                                                                    @foreach($city as $c)
                                                                        <option @if(\Illuminate\Support\Facades\Auth::user()->getAddressDelivery?->sehir_id == $c->id) selected="" @endif value="{{$c->id}}">{{$c->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6 col-12">
                                                                <label for="counties_id_delivery">İlçe</label>
                                                                <select name="counties_id_delivery" class="form-control" id="counties_id_delivery">
                                                                    <option value="">Lütfen Seçim Yapınız</option>
                                                                    @foreach($counties_delivery as $delivery_counties)
                                                                        <option @if(\Illuminate\Support\Facades\Auth::user()->getAddressDelivery?->ilce_id == $delivery_counties->id) selected="" @endif value="{{$delivery_counties->id}}">{{$delivery_counties->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-md-6 col-12">
                                                                <label for="semt_delivery">Semt</label>
                                                                <input type="text" class="form-control" id="semt_delivery" name="semt_delivery" value="{{\Illuminate\Support\Facades\Auth::user()->getAddressDelivery?->semt ?? ''}}">
                                                            </div>
                                                            <div class="form-group col-md-6 col-12">
                                                                <label for="mahalle_delivery">Mahalle</label>
                                                                <input type="text" class="form-control" id="mahalle_delivery" name="mahalle_delivery" value="{{\Illuminate\Support\Facades\Auth::user()->getAddressDelivery?->mahalle ?? ''}}">
                                                            </div>
                                                            <div class="form-group col-md-12 col-12">
                                                                <label for="address_delivery">Adres</label>
                                                                <textarea class="form-control" name="address_delivery" id="address_delivery" class="address_delivery">{{\Illuminate\Support\Facades\Auth::user()->getAddressDelivery?->adres ?? ''}}</textarea>
                                                            </div>
                                                            <div class="custom-control custom-checkbox col-md-12 col-12">
                                                                <input type="checkbox" checked="" class="custom-control-input"  name="delivery_invoice_same" id="delivery_invoice_same" value="delivery_invoice_same" onchange="delivery_invoice_same_function()">
                                                                <label for="delivery_invoice_same">
                                                                    Fatura Adresim İle Teslimat Adresim Aynı
                                                                </label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="invoice_cont d-none">
                                                        <input type="hidden" name="invoice_address_id" value="{{\Illuminate\Support\Facades\Auth::user()->getAddressInvoice?->id ?? ''}}">

                                                        <span class="mb-2 fs-12 fw-semibold d-block">Fatura Adresi</span>
                                                        <div class="pb-0 mt-0">
                                                            <div class="row">
                                                                <div class="form-group col-md-6 col-12">
                                                                    <label for="city_id_invoice">Şehir</label>
                                                                    <select name="city_id_invoice" class="form-control" id="city_id_invoice" onchange="change_city('counties_id_invoice','city_id_invoice')">
                                                                        <option value="">Lütfen Seçim Yapınız</option>
                                                                        @foreach($city as $c)
                                                                            <option @if(\Illuminate\Support\Facades\Auth::user()->getAddressInvoice?->sehir_id == $c->id) selected="" @endif value="{{$c->id}}">{{$c->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6 col-12">
                                                                    <label for="counties_id_invoice">İlçe</label>
                                                                    <select name="counties_id_invoice" class="form-control" id="counties_id_invoice">
                                                                        <option value="">Lütfen Seçim Yapınız</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6 col-12">
                                                                    <label for="semt_invoice">Semt</label>
                                                                    <input type="text" class="form-control" id="semt_invoice" name="semt_invoice" value="{{\Illuminate\Support\Facades\Auth::user()->getAddressInvoice?->semt ?? ''}}">
                                                                </div>
                                                                <div class="form-group col-md-6 col-12">
                                                                    <label for="mahalle_invoice">Mahalle</label>
                                                                    <input type="text" class="form-control" id="mahalle_invoice" name="mahalle_invoice" value="{{\Illuminate\Support\Facades\Auth::user()->getAddressInvoice?->mahalle ?? ''}}">
                                                                </div>
                                                                <div class="form-group col-md-12 col-12">
                                                                    <label for="address">Adres</label>
                                                                    <textarea class="form-control" name="address_invoice" id="address_invoice" class="address_invoice">{{\Illuminate\Support\Facades\Auth::user()->getAddressInvoice?->adres}}</textarea>
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
                            <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                                <div class="card sales-card">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="ps-4 pt-4 pe-3 pb-4">
                                                <div class="">
                                                    <span class="mb-2 fs-12 fw-semibold d-block">Kayıtlı Kartlarım</span>
                                                </div>
                                                <div class="pb-0 mt-0">
                                                    <div class="d-flex table-responsive">

                                                        @if(count($card_list->save_card) == 0 || empty($card_list->save_card))
                                                            <div class="col-12 text-center">
                                                                <h4 class="col-12 text-center">Kayıtlı Kartınız Yok Lütfen Kart Ekleyiniz.</h4>
                                                                <a href="{{route('CreditCardList',['return_url' => route('BasketList')])}}" class="btn btn-success btn-info"> <i class="fa fa-credit-card"></i> Kart Ekle</a>
                                                            </div>
                                                        @else
                                                            <table id="cart" class="table table-hover table-condensed">
                                                                <thead>
                                                                <tr>
                                                                    <th ></th>
                                                                    <th ></th>
                                                                    <th >Ad Soyad</th>
                                                                    <th  class="text-center">Kart Numarası</th>
                                                                    <th >Son Kullanma Tarihi</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($card_list->save_card as $card)
                                                                    <tr >
                                                                        <td>
                                                                            <label for="{{$card->ctoken}}">
                                                                                <input type="radio" class="select-radio" name="ctoken" id="{{$card->ctoken}}" value="{{$card->ctoken}}">

                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <label for="{{$card->ctoken}}">
                                                                                @if($card->schema == "MASTERCARD")
                                                                                    <img src="{{asset('nowa-panel/assets/images/credit-cards/card.png')}}" style="max-width: 32px;" alt="">
                                                                                @elseif($card->schema == "VISA")
                                                                                    <img src="{{asset('nowa-panel/assets/images/credit-cards/visa.png')}}" style="max-width: 32px;" alt="">
                                                                                @endif

                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <label for="{{$card->ctoken}}">
                                                                                {{$card->c_name}}
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <label for="{{$card->ctoken}}">
                                                                                **** **** **** {{$card->last_4}}
                                                                            </label>
                                                                        </td>
                                                                        <td>
                                                                            <label for="{{$card->ctoken}}">
                                                                                {{$card->month}}/{{$card->year}}
                                                                            </label>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach

                                                                </tbody>
                                                                <tfoot>
                                                                <tr>
                                                                    <td colspan="3" class=""><a href="{{route('CreditCardList',['return_url' => route('BasketList')])}}" class="btn btn-success btn-info"> <i class="fa fa-credit-card"></i> Kart Ekle</a></td>
                                                                    <td colspan="2"><button type="submit" href="#" class="btn btn-success btn-block">Öde <i class="fa fa-angle-right"></i></button></td>
                                                                </tr>
                                                                </tfoot>
                                                            </table>
                                                        @endif
                                                    </div>
                                                </div>
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
                                <div class="modal-footer">
                                    <a href="{{route('CreditCardList',['return_url' => route('BasketList')])}}" class="btn btn-success btn-info"> <i class="fa fa-credit-card"></i> Kart Ekle</a>
                                    <button type="button" class="btn btn-success sanal_dcard_modal_hide" >Kapat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            </div>
        </div>
    </div>
@endsection

@section('JsContent')
    @if(count($basket) != 0)
        <script>


            $('.sanal_dcard_modal_hide').click(function(){
                $('#sanal_dcard_modal').modal('hide');
            })
            function delivery_invoice_same_function(){
                var checkbox = $("#delivery_invoice_same");
                console.log(checkbox.is(":checked"))
                if (checkbox.is(":checked")) {
                    $('.invoice_cont').addClass('d-none');
                } else {
                    $('.invoice_cont').removeClass('d-none');
                }
            }
            function change_city(counties_select,city_select){
                $('#loader').removeClass('d-none');
                var city_id = $('#'+city_select).val();
                console.log(city_id)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: '{{route('getCounties')}}',
                    type: 'POST',
                    data: {
                        city_id: city_id,
                    },
                    success: function (response) {
                        if(response.type == "true"){
                            $('#'+counties_select).html(response.return_text);
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
            }
            $('.deleteBasket').click(function(){
                var basket_id = $(this).attr('data-id');
                Swal.fire({
                    title: 'Ürün Sepetten Silinecek Emin Misiniz?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, sil!',
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
                            url: '{{route('ProductsDelete')}}',
                            data: {basket_id:basket_id},
                            success: function (data) {
                                if(data.type == "true"){
                                    Toastify({
                                        title: "success",
                                        text: data.message,
                                        style: {
                                            background: "green",
                                        },
                                        offset: {
                                            x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                            y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                        },
                                    }).showToast();
                                    if(data.basket_count == 0){
                                        location.reload();
                                    }else{
                                        $('.basket_tr_'+basket_id).remove();
                                        $('#loader').addClass('d-none');
                                    }
                                }else{
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
                                if(data.basket_count == 0){
                                    location.reload();
                                }else{
                                    $('#loader').addClass('d-none');
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
                                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                    },
                                }).showToast();

                                $('#loader').addClass('d-none');
                            }

                        });
                    }
                });
            })
            $('.quantity_input').change(function(){
                var basket_id = $(this).attr('data-id');
                var piece = $(this).val();
                $('#loader').removeClass('d-none');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: '{{route('ProductsUpdate')}}',
                    data: {basket_id:basket_id,piece:piece},
                    success: function (data) {
                        if(data.type == "true"){
                            Toastify({
                                title: "success",
                                text: data.message,
                                style: {
                                    background: "green",
                                },
                                offset: {
                                    x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                    y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                                },
                            }).showToast();
                            $('#loader').addClass('d-none');
                            $('.subtotal_product_'+basket_id).html(data.basket_product_total_price)
                            $('.subtotal_basket').html(data.basket_total_price)
                        }else{
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
                            $('#loader').addClass('d-none');
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
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();

                        $('#loader').addClass('d-none');
                    }

                });
            })

            $('#basket_pay').on('submit',function(e){
                e.preventDefault();
                $('#loader').removeClass('d-none');
                var form = new FormData(this);
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('action'),
                    data : form,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if(data.type == "success"){
                            window.location.href = '{{route('Orders')}}'
                        }else{
                            $('#sanal_dcard_modal').modal('show');
                            var iframe = $('#sanaldmodalbodyIframe')[0];
                            var doc = iframe.contentDocument || iframe.contentWindow.document;
                            doc.open();
                            doc.write(data.response);
                            doc.close();

                            $('#loader').addClass('d-none');
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

                        $('#loader').addClass('d-none');
                    }

                });
            });

        </script>
    @endif
@endsection

