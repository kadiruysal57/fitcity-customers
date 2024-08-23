@extends('Kpanel.layouts.app')

@section('page-title') Error @endsection
@section('CssContent')

@endsection

@section('content')

    <div class="main-content">
        <div class="col-12">
            <div class="card card-transparent mx-auto text-center">
                <h1 class="text-secondary lh-1" style="font-size: 200px">404</h1>
                <hr class="w-30px">
                <h3 class="text-uppercase">{{__('global.404text')}}</h3>

                <hr class="w-30px">

            </div>
        </div>
    </div>

@endsection

