
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
                @foreach($products as $p)
                    @if($p->getStockCheck() > 0)
                        <div class="col-md-2 col-6">
                            <div class="card " style="">
                                <img src="{{$p->image_url}}" class="card-img-top" alt="...">
                                <div class="card-body text-center">
                                    <h5 class="card-title col-12">{{$p->name}}</h5><br>
                                    <p class="card-text"><b>Fiyat :</b> {{$p->price}}₺</p>
                                    @if($p->quantity <= 10)
                                        <p class="card-text text-warning"> Son {{$p->quantity}} Adet</p>
                                    @endif
                                    <button type="button" class="btn btn-primary col-12 addBasket" data-id="{{$p->id}}">Sepete Ekle</button>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('JsContent')
    <script>
        $('.addBasket').click(function(){
            $('#loader').removeClass('d-none');
            var id = $(this).attr('data-id');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({

                type: 'POST',

                url: '{{route('ProductsAdd')}}',

                data: {id:id},
                success: function (data) {
                    if(data.type=="true"){
                        Swal.fire({
                            title: data.message,
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sepeti Görüntüle',
                            cancelButtonText: 'Alışverişe Devam Et',

                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#loader').removeClass('d-none');
                                window.location.href = "{{route('BasketList')}}";

                            }
                        });
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
        })
    </script>
@endsection

