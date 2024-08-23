@extends('Kpanel.layouts.app')

@section('page-title')
    Kişisel Bilgilerim
@endsection
@section('CssContent')
@endsection

@section('content')

    <div class="main-content">
        <div class="col-12">
            <div class="card card-transparent mx-auto">
                <div class="card" style="    border-bottom: none !important">
                    <div class="card-header">
                        <h3 class="card-title">Kişisel Bilgilerim</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('PersonelInformationUpdate')}}">
                            @csrf
                            <div class="row">
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif

                                <div class="col-md-4 col-12">
                                    <label for="name">Ad</label>
                                    <input type="text" class="form-control" name="name" value="{{$user->ad}}" required="">
                                </div>
                                <div class="col-md-4 col-12 mt-1">
                                    <label for="last_name">Soyad</label>
                                    <input type="text" class="form-control" name="last_name" value="{{$user->soyad}}" required="">
                                </div>
                                <div class="col-md-4 col-12 mt-1">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" name="email" required="" value="{{$user->email}}">
                                </div>
                                <div class="col-md-4 col-12 mt-1">
                                    <label for="birthday">Doğum Tarihi</label>
                                    <input type="date" class="form-control" name="birthday" required="" value="{{$user->infos->dogum_tarihi ?? ''}}">
                                </div>
                                <div class="col-md-4 col-12 mt-1">
                                    <label for="male">Cinsiyet</label>
                                    <select name="male" class="form-control" id="male" required="">
                                        <option value="">Lutfen Seçim Yapınız</option>
                                        <option @if($user->infos->cinsiyet == 1) selected="" @endif value="1">Erkek</option>
                                        <option @if($user->infos->cinsiyet == 2) selected="" @endif value="2">Kadın</option>
                                    </select>
                                </div>
                                <div class="col-md-4 col-12 mt-1">
                                    <label for="boy">Boy</label>
                                    <input type="number" class="form-control" name="boy" required="" value="{{$user->infos->height ?? ''}}">
                                </div>
                                <div class="col-md-4 col-12 mt-1">
                                    <label for="kilo">Kilo</label>
                                    <input type="number" class="form-control" name="kilo" required="" value="{{$user->infos->weight ?? ''}}">
                                </div>

                                <div class="col-md-12 col-12 mt-1 text-center">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Kaydet</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('JsContent')
@endsection
