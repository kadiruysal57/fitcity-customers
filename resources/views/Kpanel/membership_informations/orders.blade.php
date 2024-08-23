@extends('Kpanel.layouts.app')

@section('page-title')
    Siparişlerim
@endsection
@section('CssContent')
@endsection

@section('content')

    <div class="main-content">
        <div class="col-12">
            <div class="card card-transparent mx-auto text-center">
                <div class="card" style="    border-bottom: none !important">
                    <div class="card-header">
                        <h3 class="card-title">Siparişlerim</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-separated dataTables">
                                <thead class="text-center">
                                    <th>Sipariş Numarası</th>
                                    <th>Sipariş Detayı</th>
                                    <th>Durum</th>
                                    <th>Odenen Miktar</th>
                                </thead>
                                <tbody class="package_cancelled_modal_tbody text-center">
                                    @foreach($orders as $o)

                                        <tr>
                                            <td>{{$o->merchant_oid}}</td>
                                            <td>
                                                @foreach($o->orderProducts as $product)
                                                    @if($product->product_type == 2)
                                                        {{$product->Packages?->name ?? 'BULUNAMADI'}},
                                                    @else
                                                        {{$product->Product->name}},
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                @if($o->step_status == 1)
                                                    <span class="text-success">Teslim Edildi.</span>
                                                @elseif($o->step_status == 2)
                                                    <span class="text-warning">Kargo</span>
                                                @elseif($o->step_status == 3)
                                                    <span class="text-warning">Hazırlanıyor</span>
                                                @elseif($o->step_status == 4)
                                                    <span class="text-warning">Onay Bekliyor</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($o->price != $o->total_price)
                                                    <del>{{$o->price}}₺</del> {{$o->total_price}}₺
                                                @else
                                                    {{$o->total_price}}₺
                                                @endif

                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('JsContent')
@endsection
