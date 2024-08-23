<?php

namespace App\Exports;

use App\Models\customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class customerExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data['customer']  = customer::orderBy('id','desc');
        if(!empty($_GET['customer_name'])){
            $data['customer'] = $data['customer']->where('name_surname','like','%'.$_GET['customer_name'].'%');
        }
        if(!empty($_GET['customer_email'])){
            $data['customer'] = $data['customer']->where('email','like','%'.$_GET['customer_email'].'%');
        }
        if(!empty($_GET['customer_phone'])){
            $data['customer'] = $data['customer']->where('phone','like','%'.$_GET['customer_phone'].'%');
        }
        if(!empty($_GET['customer_birthday'])){
            $data['customer'] = $data['customer']->where('birthday',date('Y-m-d H:i:s',strtotime($_GET['customer_birthday'])));
        }

        if(!empty($_GET['buildings_filter'])){
            $data['customer'] = $data['customer']->where('buildings_id',$_GET['buildings_filter']);
        }
        if(!empty($_GET['buildings_properties'])){
            $data['customer'] = $data['customer']->where('buildings_properties_id',$_GET['buildings_properties']);
        }
        if(!empty($_GET['customer_apartment'])){
            $data['customer'] = $data['customer']->where('apartment_id',$_GET['customer_apartment']);
        }
        if(!empty($_GET['customer_category'])){
            $data['customer'] = $data['customer']->where('category_id',$_GET['customer_category']);
        }
        if(!empty($_GET['customer_category'])){
            $data['customer'] = $data['customer']->where('category_id',$_GET['customer_category']);
        }
        $data['customer'] = $data['customer']->get();
        return view('exports.customer',$data);
    }
}
