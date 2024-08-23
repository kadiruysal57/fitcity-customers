<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Counties;
use App\Models\Customer;
use App\Models\Packages;
use Illuminate\Http\Request;

class ApiController extends Controller
{
        public function getCustomerPhoneCheck(Request $request){

        if(!empty($request->telephone)){
            $telefon = "0".$request->telephone;
            $telefon = str_replace(['(',')',' '],['','',''],$telefon);
            $user_check = Customer::where('telefon',$telefon)->first();
            if(!empty($user_check)){
                return response()->json(['type'=>'true','message'=>'Kullanıcı Bulundu.','route_url'=>route('sign_in',['telefon'=>str_replace('0','',$telefon)])]);
            }else{
                return response()->json(['type'=>'false','message'=>'Kullanıcı Bulunamadı']);
            }
        }else{
            return response()->json(['type'=>'false','message'=>'Kullanıcı Bulunamadı']);

        }


    }

    public function getContractsCustomer(Request $request){
        if(!empty($request->contract_id)){
            $contract = Contract::find($request->contract_id);
            if(!empty($contract)){

                if($request->contract_id == 2){
                    $contract_text = $contract->contracts_text;


                }else{

                    if(!empty($request->package_id)){
                        $package = Packages::find($request->package_id);
                        $contract_text = str_replace('[name]','',$contract->contracts_text);
                        $contract_text = str_replace('[surname]','',$contract_text);
                        $contract_text = str_replace('[tc]','',$contract_text);
                        $contract_text = str_replace('[address]','',$contract_text);
                        $contract_text = str_replace('[phone]','',$contract_text);
                        $contract_text = str_replace('[email]','',$contract_text);
                        $contract_text = str_replace('[club_name]','Eva Sportif',$contract_text);
                        $contract_text = str_replace('[start_date]',date('d.m.Y'),$contract_text);
                        $contract_text = str_replace('[not_discount_price]',number_format($package->price, 2, ',', '.')."₺",$contract_text);
                        $contract_text = str_replace('[discount_price]',number_format($package->discount_price, 2, ',', '.')."₺",$contract_text);
                        $contract_text = str_replace('[total_discount_price]',number_format(($package->discount_price * 12), 2, ',', '.')."₺",$contract_text);
                        $contract_text = str_replace('[discount_diff]',number_format(($package->price - $package->discount_price), 2, ',', '.')."₺",$contract_text);

                        /*$customer = Customer::find(Auth::user()->id);
                        $contract_text = str_replace('[name]',$customer->ad." ".$customer->ikinci_ad,$contract->contract_text);
                        $contract_text = str_replace('[surname]',$customer->soyad,$contract_text);
                        $contract_text = str_replace('[tc]',$customer->soyad,$contract_text);
                        if(!empty($customer->address)){
                            $address = $customer->address->city->name ?? '';
                            $address .= "/".$customer->address->counties->name ?? '';
                            $address .= $customer->semt." ";
                            $address .= $customer->mahalle." ";
                            $address .= $customer->address." ";
                        }else{
                            $address = '';
                        }

                        $contract_text = str_replace('[address]',$address,$contract_text);
                        $contract_text = str_replace('[phone]',$customer->telefon,$contract_text);
                        $contract_text = str_replace('[email]',$customer->email,$contract_text);
                        $contract_text = str_replace('[club_name]','Eva Sportif',$contract_text);
                        $contract_text = str_replace('[start_date]',date('d.m.Y'),$contract_text);
                        $contract_text = str_replace('[not_discount_price]',$package->price,$contract_text);
                        $contract_text = str_replace('[discount_price]',$package->discount_price,$contract_text);
                        $contract_text = str_replace('[total_discount_price]',($package->discount_price * 12),$contract_text);
                        $contract_text = str_replace('[discount_diff]',($package->price - $package->discount_price),$contract_text);*/
                    }else{
                        return response()->json(['type'=>'false','message'=>'Sözleşme Bulunamadı.']);
                    }
                }
                return response()->json(['type'=>'true','contract_text'=>$contract_text]);

            }else{
                return response()->json(['type'=>'false','message'=>'Sözleşme Bulunamadı.']);
            }
        }else{
            return response()->json(['type'=>'false','message'=>'Sözleşme Bulunamadı.']);
        }
    }

    public function getCounties(Request $request){
        if(!empty($request->city_id)){
            $counties = Counties::where('city_id',$request->city_id)->get();
            $return_text = '<option>Lütfen Seçim Yapınız</option>';
            foreach($counties as $c){
                $return_text .= "<option value='".$c->id."'>".$c->name."</option>";
            }
            return response()->json(['type'=>'true','return_text'=>$return_text]);
        }else{
            return response()->json(['type'=>'false','message'=>'Şehir Bulunamadı.']);
        }
    }
}
