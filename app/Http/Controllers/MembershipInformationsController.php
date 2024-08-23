<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\CustomerInfo;
use App\Models\CustomerPackages;
use App\Models\Measurement;
use App\Models\Orders;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipInformationsController extends Controller
{
    public function MembershipInformation(){



        $result = makeApiRequest('https://api.fitcity.com.tr/api/card_list',session('api_token'));
        if($result['success'] == 'true'){
            $data['credits'] = json_decode($result['data']);
            $data['user_package'] = CustomerPackages::where('customer_id',Auth::user()->id)->whereHas('package')
                ->get();
            $data['packages'] = Packages::where('status',1)->get();
            $data['year_packages'] = Packages::where('status',1)->where('contracts_type',2)->where('mobil_view',2)->get();
            $data['month_packages'] = Packages::where('status',1)->where('contracts_type',1)->where('mobil_view',2)->get();

            return view('Kpanel.membership_informations.membership_informations')->with($data);
        }else{
            return view('Kpanel.405');
        }
    }

    public function MembershipCheck(Request $request){
        $package = CustomerPackages::where('customer_id',Auth::user()->id)->whereHas('package')->count();
        if($package > 0 ){
            return response()->json(['type'=>'true']);
        }else{
            return response()->json(['type'=>'false']);
        }


    }

    public function MembershipCancelled(Request $request){
        $customer_package = CustomerPackages::find($request->id);
        if(!empty($customer_package)){
            $start_date = strtotime($customer_package->start_date);
            $finish_date = strtotime($customer_package->finish_date);

            $year_diff_in_months = (date('Y', $finish_date) - date('Y', $start_date)) * 12;
            $month_diff = date('m', $finish_date) - date('m', $start_date);
            $total_month_diff = $year_diff_in_months + $month_diff;

            $discount_price_diff = $customer_package->price - $customer_package->discount_price;
            $pay_discount_price_diff = $discount_price_diff * $total_month_diff;
            $html_text = '<tr>
                <td>'.date('d.m.Y',strtotime($customer_package->start_date)).'</td>
                <td>'.date('d.m.Y',strtotime($customer_package->finish_date)).'</td>
                <td>'.$customer_package->discount_price*$total_month_diff.'₺</td>
                <td>'.$customer_package->price*$total_month_diff.'₺</td>
                <td>'.$pay_discount_price_diff.'₺</td>
            </tr>';

            return response()->json(['type'=>'true','status'=>"2",'text'=>$html_text]);
        }else{
            return response()->json(['type'=>'false','response'=>"Bir hata oluştu sonra tekrar deneyiniz."]);
        }
    }

    Public function Orders(Request $request){
        $data['orders'] = Orders::where('customer_id',Auth::user()->id)
            ->whereHas('orderProducts')
            ->where('status',1)
            ->get();


        return view('Kpanel.membership_informations.orders')->with($data);
    }
    Public function OrderDetail($id){
        $data['orders'] = Orders::where('customer_id',$id)->whereHas('orderProducts')->first();

        return view('Kpanel.membership_informations.orders')->with($data);
    }

    Public function PersonelInformation(){

        $data['user'] = Customer::find(Auth::user()->id);
        return view('Kpanel.membership_informations.personel_information')->with($data);
    }
    public function PersonelInformationUpdate(Request $request){
        $customer = Customer::find(Auth::user()->id);
        if(!empty($customer)){
            $customer_information = CustomerInfo::where('customer_id',$customer->id)->first();
            $customer->ad = $request->name;
            $customer->soyad = $request->last_name;
            $customer->email = $request->email;
            $customer->save();

            $customer_information->dogum_tarihi = date('Y-m-d',strtotime($request->birthday));
            $customer_information->cinsiyet = $request->male;
            $customer_information->height = $request->boy;
            $customer_information->weight = $request->kilo;
            $customer_information->save();
            return redirect()->back()->with('success','Güncelleme Başarılı');
        }else{
            return redirect()->back()->with('error','Güncelleme Başarısız');
        }

    }

    public function Measurements(){
        $data['measurements'] = Measurement::where('customer_id',Auth::user()->id)->get();

        return view('Kpanel.membership_informations.measurements')->with($data);
    }
    public function MeasurementsEdit($id){
        $measurement = Measurement::find($id);
        if(!empty($measurement)){
            $data['measurement'] = $measurement;


            return view('Kpanel.membership_informations.measurement_edit')->with($data);
        }else{
            return view('Kpanel.404');
        }

    }
}
