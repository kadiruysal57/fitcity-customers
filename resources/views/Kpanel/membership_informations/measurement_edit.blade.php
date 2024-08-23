@extends('Kpanel.layouts.app')

@section('page-title')
    Ölçümlerim
@endsection
@section('CssContent')
@endsection

@section('content')

    <div class="main-content">
        <div class="col-12">
            <div class="card card-transparent mx-auto">
                <div class="card" style="    border-bottom: none !important">
                    <div class="card-header">
                        <h3 class="card-title">Ölçümlerim</h3>
                    </div>
                    <div class="card-body">
                        <div class="col row">

                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="measurement_date">Ölçüm Tarihi</label>
                                <input type="date" name="measurement_date" class="form-control" value="{{$measurement->measurement_date}}" readonly>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="measurement_type">Ölçüm Tipi</label>
                                <select name="measurement_type" class="form-control" id="measurement_type">
                                    <option value="">Lütfen Seçim Yapınız</option>
                                    <option @if($measurement->measurement_type == 1) selected="" @endif value="1">Standart</option>
                                    <option @if($measurement->measurement_type == 2) selected="" @endif selected="" value="2">Atletik</option>
                                    <option @if($measurement->measurement_type == 3) selected="" @endif value="3">Çocuk</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="measurement_size">Boy(cm)</label>
                                <input type="number" class="form-control" id="measurement_size" name="measurement_size" value="{{$measurement->measurement_size}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="measurement_oil">Yağ(%)</label>
                                <input type="number" class="form-control" id="measurement_oil" name="measurement_oil" value="{{$measurement->measurement_oil}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="measurement_bmr">BMR(%)</label>
                                <input type="number" class="form-control" id="measurement_bmr" name="measurement_bmr" value="{{$measurement->measurement_bmr}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="measurement_visceral_fat">İç Organ Yağı(%)</label>
                                <input type="number" class="form-control" id="measurement_visceral_fat" name="measurement_visceral_fat" value="{{$measurement->measurement_visceral_fat}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="weight">Kilo</label>
                                <input type="number" class="form-control" id="weight" name="weight" value="{{$measurement->weight}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="bmi">BMI</label>
                                <input type="number" class="form-control" id="bmi" name="bmi" value="{{$measurement->bmi}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="water">Su (Tbw)</label>
                                <input type="number" class="form-control" id="water" name="water" value="{{$measurement->water}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="kas">Kas (Ffm)</label>
                                <input type="number" class="form-control" id="kas" name="kas" value="{{$measurement->kas}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="t_weight">T. weight</label>
                                <input type="text" class="form-control" id="t_weight" name="t_weight" value="{{$measurement->t_weight}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="fat_to_gain">Fat to gain</label>
                                <input type="text" class="form-control" id="fat_to_gain" name="fat_to_gain" value="{{$measurement->fat_to_gain}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="t_fat_mass">T. Fat mass</label>
                                <input type="text" class="form-control" id="t_fat_mass" name="t_fat_mass" value="{{$measurement->t_fat_mass}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="t_to_loss">T. to loss</label>
                                <input type="text" class="form-control" id="t_to_loss" name="t_to_loss" value="{{$measurement->t_to_loss}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="omuz">Omuz</label>
                                <input type="text" class="form-control" id="omuz" name="omuz" value="{{$measurement->omuz}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="bel">Bel</label>
                                <input type="text" class="form-control" id="bel" name="bel" value="{{$measurement->bel}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="sag_kol">Sağ Kol</label>
                                <input type="text" class="form-control" id="sag_kol" name="sag_kol" value="{{$measurement->sag_kol}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="sol_kol">Sol Kol</label>
                                <input type="text" class="form-control" id="sol_kol" name="sol_kol" value="{{$measurement->sol_kol}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="sag_baldir">Sağ Baldır</label>
                                <input type="text" class="form-control" id="sag_baldir" name="sag_baldir" value="{{$measurement->sag_baldir}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="dinlenik_nabiz">Dinlenik Nabız</label>
                                <input type="text" class="form-control" id="dinlenik_nabiz" name="dinlenik_nabiz" value="{{$measurement->dinlenik_nabiz}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="gogus">Göğüs</label>
                                <input type="text" class="form-control" id="gogus" name="gogus" value="{{$measurement->gogus}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="karin">Karın</label>
                                <input type="text" class="form-control" id="karin" name="karin" value="{{$measurement->karin}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="sol_baldir">Sol Baldır</label>
                                <input type="text" class="form-control" id="sol_baldir" name="sol_baldir" value="{{$measurement->sol_baldir}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="tansiyon">Tansiyon</label>
                                <input type="text" class="form-control" id="tansiyon" name="tansiyon" value="{{$measurement->tansiyon}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="gogus_alti">Göğüs altı</label>
                                <input type="text" class="form-control" id="gogus_alti" name="gogus_alti" value="{{$measurement->gogus_alti}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="kalca">Kalça</label>
                                <input type="text" class="form-control" id="kalca" name="kalca" value="{{$measurement->kalca}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="sag_bacak">Sağ bacak</label>
                                <input type="text" class="form-control" id="sag_bacak" name="sag_bacak" value="{{$measurement->sag_bacak}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="basen">Basen</label>
                                <input type="text" class="form-control" id="basen" name="basen" value="{{$measurement->basen}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="sol_bacak">Sol bacak</label>
                                <input type="text" class="form-control" id="sol_bacak" name="sol_bacak" value="{{$measurement->sol_bacak}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="bel_kalca_orani">Bel kalça oranı</label>
                                <input type="text" class="form-control" id="bel_kalca_orani" name="bel_kalca_orani" value="{{$measurement->bel_kalca_orani}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="uzun_atlama">Uzun Atlama (CM)</label>
                                <input type="text" class="form-control" id="uzun_atlama" name="uzun_atlama" value="{{$measurement->uzun_atlama}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="yarim_mekik">Yarım Mekik</label>
                                <input type="text" class="form-control" id="yarim_mekik" name="yarim_mekik" value="{{$measurement->yarim_mekik}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="denge_leylek_durusu_sag_bacak">Denge Leylek Duruşu Sağ Bacak</label>
                                <input type="text" class="form-control" id="denge_leylek_durusu_sag_bacak" name="denge_leylek_durusu_sag_bacak" value="{{$measurement->denge_leylek_durusu_sag_bacak}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="one_esneme">Öne Esneme</label>
                                <input type="text" class="form-control" id="one_esneme" name="one_esneme" value="{{$measurement->one_esneme}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="ters_mekik">Ters Mekik</label>
                                <input type="text" class="form-control" id="ters_mekik" name="ters_mekik" value="{{$measurement->ters_mekik}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="denge_leylek_durusu_sol_bacak">Denge Leylek Duruşu Sol Bacak</label>
                                <input type="text" class="form-control" id="denge_leylek_durusu_sol_bacak" name="denge_leylek_durusu_sol_bacak" value="{{$measurement->denge_leylek_durusu_sol_bacak}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="tutunma">Tutunma</label>
                                <input type="text" class="form-control" id="tutunma" name="tutunma" value="{{$measurement->tutunma}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="sinav">Şınav</label>
                                <input type="text" class="form-control" id="sinav" name="sinav" value="{{$measurement->sinav}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="yarim_barfiks">Yarım Barfiks</label>
                                <input type="text" class="form-control" id="yarim_barfiks" name="yarim_barfiks" value="{{$measurement->yarim_barfiks}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="denge_ayak_ucunda_durus_sag_bacak">Denge Ayak Ucunda Duruş Sağ Bacak</label>
                                <input type="text" class="form-control" id="denge_ayak_ucunda_durus_sag_bacak" name="denge_ayak_ucunda_durus_sag_bacak" value="{{$measurement->denge_ayak_ucunda_durus_sag_bacak}}">
                            </div>
                            <div class="form-group col-lg-4 col-md-4 col-12">
                                <label for="denge_ayak_ucunda_durus_sol_bacak">Denge Ayak Ucunda Duruş Sol Bacak</label>
                                <input type="text" class="form-control" id="denge_ayak_ucunda_durus_sol_bacak" name="denge_ayak_ucunda_durus_sol_bacak" value="{{$measurement->denge_ayak_ucunda_durus_sol_bacak}}">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('JsContent')
@endsection
