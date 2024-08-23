@extends('Kpanel.layouts.app')

@section('page-title')
    Ölçümlerim
@endsection
@section('CssContent')
@endsection

@section('content')

    <div class="main-content">
        <div class="col-12">
            <div class="card card-transparent mx-auto ">
                <div class="card" style="    border-bottom: none !important">
                    <div class="card-header">
                        <h3 class="card-title">Ölçümlerim</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-separated dataTables">
                                <thead class="text-center">
                                    <th>Ölçüm Tarihi</th>
                                    <th>Ölçüm Tipi</th>
                                    <th>Personel</th>
                                    <th>#</th>
                                </thead>
                                <tbody class=" ">
                                    @foreach($measurements as $m)
                                        <tr>
                                            <td>{{date('d.m.Y',strtotime($m->measurement_date))}}</td>
                                            <td>
                                                @if($m->measurement_date == 1)
                                                    Standart
                                                @elseif($m->measurement_date == 2)
                                                    Atletik
                                                @else
                                                    Çocuk
                                                @endif
                                            </td>
                                            <td>
                                                {{$m->getPersonel->name}}
                                            </td>
                                            <td>
                                                <a href="{{route('MeasurementsEdit',['id'=>$m->id])}}" class="btn btn-succes btn-sm"><i class="fa fa-eye"></i></a>
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
