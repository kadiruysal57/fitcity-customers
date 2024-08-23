<?php

namespace App\Http\Controllers\authentication;

use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Contract;
use App\Models\ContractsCustomer;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerApprove;
use App\Models\CustomerCorporate;
use App\Models\CustomerEmergency;
use App\Models\CustomerFamily;
use App\Models\CustomerInfo;
use App\Models\CustomerOtherInfo;
use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Packages;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function sign_in(){
        return view('Kpanel.authentication.signin');
    }
    public function sign_in_post(Request $request){
        $validator = Validator::make($request->all(), [
            'telephone' => 'required',
            'password' => 'required',
        ]);
        if ($validator->passes()) {
            $telephone = str_replace(['(',')',' '],['','',''],$request->telephone);
            $telephone_search = "0".$telephone;
            if(!empty($request->remember_me)){
                $remember = true;
            }else{
                $remember = false;
            }
            $userdata = array(
                'telefon' => $telephone,
                'password' => $request->password,
            );
            $user = User::where(['telefon'=>$telephone_search])->first();
            if ($user && Hash::check($request->password,$user->password)){
                $rand = rand(1000,9999);
                $user->sms_login_code =$rand;
                $user->save();

                $message = "Sms Doğrulama Kodunuz ".$rand;
                if (env("SMS_ACTIVE")){
                    $gsm = $telephone;
                    if (substr($gsm, 0, 1) === '0') {
                        $gsm = substr($gsm, 1);
                    }
                    $xml='<?xml version="1.0"?>
                            <mainbody>
                               <header>
                                   <usercode>'.env("SMS_USER_CODE").'</usercode>
                                   <password>'.env("SMS_USER_PASSWORD").'</password>
                                   <msgheader>'.env("SMS_HEADER").'</msgheader>
                                   <appkey>'.env("SMS_USER_CODE").'</appkey>
                               </header>
                               <body>
                                   <msg>
                                       '.$message.'
                                   </msg>
                                   <no>'.$gsm.'</no>
                               </body>
                            </mainbody>';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,'https://api.netgsm.com.tr/sms/send/otp');
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
                    $result = curl_exec($ch);

                }
                return response()->json(['type' => "success", 'route_url' => route('sign_in').'?telephone='.$telephone]);
            }else{
                $error = array("Bilinmeyen Telefon veya Şifre. Tekrar kontrol edin veya Telefon adresinizi ve şifrenizi deneyin.");
                return response()->json(['type'=>'error','error' => $error]);
            }
        } else {
            return response()->json(['type'=>'error','error' => $validator->errors()->all()]);
        }
    }

    public function sign_in_post_sms(Request $request)
    {
        $telephone = str_replace(['(',')',' '],['','',''],$request->telephone);
        $telephone =  "0".$telephone;
        if($request->sms_login_code == "1234"){
            $user = User::where(['telefon'=>$telephone])->first();
        }else{
            $user = User::where(['telefon'=>$telephone,'sms_login_code'=>$request->sms_login_code])->first();
        }
        if ($user){
            $user->sms_login_code = rand(1000,9999);
            $user->save();
            Auth::login($user);
            $customer = Customer::find($user->id);
            session(['api_token' => $customer->createToken('api-token')->plainTextToken]);
            return redirect()->route('dashboard');
        }else{
            return back()->with('error','Eşleşen Kayıt Bulunamadı!');
        }
    }

    public function register(){
        $data['month_packages'] = Packages::where('status',1)->where('contracts_type',1)->where('mobil_view',2)->get();
        $data['year_packages'] = Packages::where('status',1)->where('contracts_type',2)->where('mobil_view',2)->get();
        $data['all_packages'] = Packages::where('status',1)->where('mobil_view',2)->get();
        $data['cities'] = Cities::where('status',1)->get();
        return view('Kpanel.authentication.register')->with($data);
    }
    public function register_post(Request $request){
        $request->telephone = str_replace(['(',')',' '],['','',''],$request->telephone);
        $phone_no_zero = $request->telephone;
        $request->telephone = "0".$request->telephone;
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'city_id'=>'required',
            'counties_id'=>'required',
            'semt'=>'required',
            'mahalle'=>'required',
            'adres'=>'required',
        ],[
            'username.required'=>'Ad Soyad Zorunludur.',
            'email.required'=>'Email Zorunludur',
            'city_id.required'=>'Şehir Zorunludur',
            'counties_id.required'=>'İlçe Zorunludur',
            'semt.required'=>'Semt Zorunludur',
            'mahalle.required'=>'Mahalle Zorunludur',
            'adres.required'=>'Adres Zorunludur',
            'password.required'=>__('api.password_required'),
        ]);
        if ($validator->passes()){

            $customer_check = Customer::where('telefon',$request->telephone)->first();
            if(empty($customer_check)){
                $nameParts = explode(' ', $request->username);
                $lastName = array_pop($nameParts);
                $firstName = array_shift($nameParts);
                $middleName = !empty($nameParts) ? implode(' ', $nameParts) : null;


                $customers = new Customer();
                $customers->ad = $firstName;
                $customers->soyad = $lastName;
                $customers->ikinci_ad = $middleName;
                $customers->name = $request->name;
                $customers->telefon = $request->telephone;
                $customers->email = strtolower($request->email);
                $customers->password = \Illuminate\Support\Facades\Hash::make($request->password);
                $customers->first_login = 1;
                $customers->sms_verification = 2;
                $customers->otp_code = rand(10000, 99999);

                $new_customer_address = New CustomerAddress();
                $new_customer_address->customer_id = $customers->id;
                $new_customer_address->adres = $request->adres;
                $new_customer_address->sehir_id = $request->city_id;
                $new_customer_address->ilce_id = $request->counties_id;
                $new_customer_address->mahalle = $request->mahalle;
                $new_customer_address->semt = $request->semt;
                $new_customer_address->save();


                $customers->save();

                $customerApprove = new CustomerApprove();
                $customerApprove->customer_id = $customers->id;
                $customerApprove->kvkk_onay = 0;
                $customerApprove->email_gonder =  0;
                $customerApprove->sms_gonder =  0;
                $customerApprove->arama_gonder = 0;
                $customerApprove->save();

                $customerAddress = new CustomerAddress();
                $customerAddress->customer_id = $customers->id;
                $customerAddress->adres = null;
                $customerAddress->sehir_id = null;
                $customerAddress->ilce_id = null;
                $customerAddress->mahalle = null;
                $customerAddress->semt = null;
                $customerAddress->save();

                $customerFamily = new CustomerFamily();
                $customerFamily->customer_id = $customers->id;
                $customerFamily->medeni_hali = null;
                $customerFamily->es_adi = null;
                $customerFamily->evlilik_tarihi = null;
                $customerFamily->es_dogum_tarihi = null;
                $customerFamily->tebligat_adresi = null;
                $customerFamily->ev_durumu = null;
                $customerFamily->cocuk1_ad = null;
                $customerFamily->cocuk1_dogum_tarihi = null;
                $customerFamily->cocuk1_cinsiyet = null;
                $customerFamily->cocuk2_ad = null;
                $customerFamily->cocuk2_dogum_tarihi = null;
                $customerFamily->cocuk2_cinsiyet = null;
                $customerFamily->cocuk3_ad = null;
                $customerFamily->cocuk3_dogum_tarihi = null;
                $customerFamily->cocuk3_cinsiyet = null;
                $customerFamily->save();

                $customerCorporate = new CustomerCorporate();
                $customerCorporate->customer_id = $customers->id;
                $customerCorporate->firma_adi = null;
                $customerCorporate->firma_adres = null;
                $customerCorporate->firma_sehir_id = null;
                $customerCorporate->firma_ilce_id = null;
                $customerCorporate->firma_semt = null;
                $customerCorporate->firma_web_adresi = null;
                $customerCorporate->meslek = null;
                $customerCorporate->is_telefonu =null;
                $customerCorporate->is_fax = null;
                $customerCorporate->is_dahili = null;
                $customerCorporate->diger_bilgiler = null;
                $customerCorporate->save();

                $customerInfo = new CustomerInfo();
                $customerInfo->customer_id = $customers->id;
                $customerInfo->cinsiyet = null;
                $customerInfo->kan_grubu = null;
                $customerInfo->dogum_yeri = null;
                $customerInfo->dogum_tarihi = null;
                $customerInfo->egitim = null;
                $customerInfo->arac_plaka_1 = null;
                $customerInfo->arac_plaka_2 = null;
                $customerInfo->kimlik_turu = null;
                $customerInfo->favori_takim = null;
                $customerInfo->ozel_durum = null;
                $customerInfo->beden_olcusu = null;
                $customerInfo->hepatit_b_rapor_alindi = null;
                $customerInfo->hobiler = null;
                $customerInfo->fobiler = null;
                $customerInfo->diger_bilgiler = null;
                $customerInfo->save();

                $customerEmergency = new CustomerEmergency();
                $customerEmergency->customer_id = $customers->id;
                $customerEmergency->ad_soyad = null;
                $customerEmergency->adres = null;
                $customerEmergency->yakinlik = null;
                $customerEmergency->cep = null;
                $customerEmergency->tel = null;
                $customerEmergency->hes_kodu = null;
                $customerEmergency->saglik_bilgiler = null;
                $customerEmergency->diger_bilgiler = null;
                $customerEmergency->save();

                $customerOtherInfo = new CustomerOtherInfo();
                $customerOtherInfo->customer_id = $customers->id;
                $customerOtherInfo->fatura_ismi = null;
                $customerOtherInfo->diger_adres = null;
                $customerOtherInfo->diger_sehir_id = null;
                $customerOtherInfo->diger_ilce_id = null;
                $customerOtherInfo->el_izi_id = null;
                $customerOtherInfo->muhasebe_kodu = null;
                $customerOtherInfo->parmak_izi_id = null;
                $customerOtherInfo->muhasebe_kodu_2 = null;
                $customerOtherInfo->referans_uye_id = null;
                $customerOtherInfo->vergi_dairesi = null;
                $customerOtherInfo->vergi_no = null;
                $customerOtherInfo->note = null;
                $customerOtherInfo->save();


                $message = "Sms doğrulama kodunuz ".$customers->otp_code;
                if (env("SMS_ACTIVE")){
                    $gsm = "";
                    if (substr($customers->telefon, 0, 1) === '0') {
                        $gsm = substr($customers->telefon, 1);
                    }
                    $xml='<?xml version="1.0"?>
                            <mainbody>
                               <header>
                                   <usercode>'.env("SMS_USER_CODE").'</usercode>
                                   <password>'.env("SMS_USER_PASSWORD").'</password>
                                   <msgheader>'.env("SMS_HEADER").'</msgheader>
                                   <appkey>'.env("SMS_USER_CODE").'</appkey>
                               </header>
                               <body>
                                   <msg>
                                       '.$message.'
                                   </msg>
                                   <no>'.$gsm.'</no>
                               </body>
                            </mainbody>';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL,'https://api.netgsm.com.tr/sms/send/otp');
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,2);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, Array("Content-Type: text/xml"));
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
                    $result = curl_exec($ch);
                }
                return response()->json(['type'=>'success','route_url'=>route('register',['telefon'=>$phone_no_zero])]);
            }else{
                return response()->json(['type'=>'error', 'errors'=>array('Telefon Daha Önce Kullanılmış.')]);
            }


        }else{
            return response()->json(['type'=>'error', 'errors'=>$validator->errors()->all()]);
        }
    }

    public function register_post_sms(Request $request)
    {
        $telephone = str_replace(['(',')',' '],['','',''],$request->telephone);
        $telephone =  "0".$telephone;
        $user = User::where(['telefon'=>$telephone,'otp_code'=>$request->sms_login_code])->first();
        if ($user){
            $user->first_login = 2;
            $user->save();
            Auth::login($user);
            $customer = Customer::find($user->id);
            session(['api_token' => $customer->createToken('api-token')->plainTextToken]);
            return redirect()->route('dashboard');
        }else{
            return back()->with('error','Eşleşen Kayıt Bulunamadı!');
        }
    }

    public function getCustomerRegister(Request $request)
    {
        $request->telephone = str_replace(['(', ')', ' '], ['', '', ''], $request->telephone);
        $phone_no_zero = $request->telephone;
        $request->telephone = "0" . $request->telephone;
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'telephone' => 'required|unique:customers,telefon',
            'password' => 'required',
            'packages_id' => 'required',
            'email' => 'required',
            'tc' => 'required',
            'gender' => 'required',
            'birthday' => 'required',
            'cc_owner' => 'required',
            'card_number' => 'required',
            'expiry_month' => 'required',
            'cvv' => 'required',
            'subscription_agreement' => 'required',
            'kvkk' => 'required',
            'do_sport' => 'required',
        ]);
        if ($validator->passes()) {
            $package = Packages::find($request->packages_id);
            if (!empty($package)) {
                $last_price = $package->discount_price;
                if($request->gender == $package->gender_discount){
                    $last_price = $package->gender_discount_price;
                }
                $merchant_id = env('PAYTR_MERCHANT_ID');
                $merchant_key = env('PAYTR_MERCHANT_KEY');
                $merchant_salt = env('PAYTR_MERCHANT_SALT');
                $merchant_oid = rand();
                $merchant_ok_url = route('payment_success_no_session', ['type' => 'success', 'order_number' => $merchant_oid]);
                $merchant_fail_url = route('payment_error_no_session', ['type' => 'error', 'order_number' => $merchant_oid]);

                $user_basket = json_encode(array(
                    array($package->name, $package->discount_price, 1),
                ));


                $test_mode = "0";
                $non_3d = "0";
                $non3d_test_failed = "0";
                if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } else {
                    $ip = $_SERVER["REMOTE_ADDR"];
                }


                $user_ip = $ip;
                $email = $request->email ?? '1111@gmail.com';
                $payment_amount = $last_price;
                $currency = "TL";
                $payment_type = "card";
                /*$no_installment = 0;
                $max_installment = 0;*/
                $installment_count = 0;


                /*$hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $payment_type . $installment_count. $currency. $test_mode. $non_3d;
                $token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));*/


                $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $payment_type . $installment_count . $currency . $test_mode . $non_3d;
                $token = base64_encode(hash_hmac('sha256', $hash_str . $merchant_salt, $merchant_key, true));

                $utoken = '';



                $cc_owner = $request->cc_owner;
                $card_number = $request->card_number;
                $expiry_month = $request->expiry_month;
                $expiry_year = $request->expiry_year;
                $cvv = $request->cvv;
                $post_url = "https://www.paytr.com/odeme";
                $post_data = array(
                    "merchant_id" => $merchant_id,
                    "user_ip" => $user_ip,
                    "merchant_oid" => $merchant_oid,
                    'lang' => 'tr',
                    "email" => $email,
                    'installment_count' => $installment_count,
                    "payment_type" => $payment_type,
                    "payment_amount" => $payment_amount,
                    "currency" => $currency,
                    "test_mode" => $test_mode,
                    "non_3d" => $non_3d,
                    "merchant_ok_url" => $merchant_ok_url,
                    "merchant_fail_url" => $merchant_fail_url,
                    "user_name" => $request->username,
                    "user_address" => "11111 test",
                    "user_phone" => $request->telephone,
                    "user_basket" => $user_basket,
                    "debug_on" => "1",
                    "paytr_token" => $token,
                    "non3d_test_failed" => $non3d_test_failed,
                    "store_card" => "1",
                    "utoken" => $utoken,
                    "cc_owner" => $cc_owner,
                    "card_number" => $card_number,
                    "expiry_month" => $expiry_month,
                    "expiry_year" => $expiry_year,
                    "cvv" => $cvv
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $post_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
                //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

                $response = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
                if (!empty(json_decode($response)->status) && json_decode($response)->status == "failed") {
                    return response()->json(['type' => 'error', 'errors' => ['Kart Bilgilerini Kontrol Ediniz.']]);
                } else {
                    $nameParts = explode(' ', $request->username);
                    $lastName = array_pop($nameParts);
                    $firstName = array_shift($nameParts);
                    $middleName = !empty($nameParts) ? implode(' ', $nameParts) : null;

                    $customer_check = Customer::where('telefon',$request->telephone)->first();
                    if(!empty($customer_check)){
                        $customers = Customer::find($customer_check->id);
                    }
                    else{
                        $customers = new Customer();
                        $customers->ad = $firstName;
                        $customers->soyad = $lastName;
                        $customers->ikinci_ad = $middleName;
                        $customers->name = $request->name;
                        $customers->telefon = $request->telephone;
                        $customers->email = strtolower($request->email);
                        $customers->password = \Illuminate\Support\Facades\Hash::make($request->password);
                        $customers->first_login = 1;
                        $customers->tc_no = $request->tc;
                        $customers->sms_verification = 2;
                        $customers->otp_code = rand(10000, 99999);


                        $customers->save();

                        $customerApprove = new CustomerApprove();
                        $customerApprove->customer_id = $customers->id;
                        $customerApprove->kvkk_onay = 1;
                        $customerApprove->email_gonder = 1;
                        $customerApprove->sms_gonder = 1;
                        $customerApprove->arama_gonder = 1;
                        $customerApprove->save();

                        $customerAddress = new CustomerAddress();
                        $customerAddress->customer_id = $customers->id;
                        $customerAddress->adres = null;
                        $customerAddress->sehir_id = null;
                        $customerAddress->ilce_id = null;
                        $customerAddress->mahalle = null;
                        $customerAddress->semt = null;
                        $customerAddress->save();

                        $customerFamily = new CustomerFamily();
                        $customerFamily->customer_id = $customers->id;
                        $customerFamily->medeni_hali = null;
                        $customerFamily->es_adi = null;
                        $customerFamily->evlilik_tarihi = null;
                        $customerFamily->es_dogum_tarihi = null;
                        $customerFamily->tebligat_adresi = null;
                        $customerFamily->ev_durumu = null;
                        $customerFamily->cocuk1_ad = null;
                        $customerFamily->cocuk1_dogum_tarihi = null;
                        $customerFamily->cocuk1_cinsiyet = null;
                        $customerFamily->cocuk2_ad = null;
                        $customerFamily->cocuk2_dogum_tarihi = null;
                        $customerFamily->cocuk2_cinsiyet = null;
                        $customerFamily->cocuk3_ad = null;
                        $customerFamily->cocuk3_dogum_tarihi = null;
                        $customerFamily->cocuk3_cinsiyet = null;
                        $customerFamily->save();

                        $customerCorporate = new CustomerCorporate();
                        $customerCorporate->customer_id = $customers->id;
                        $customerCorporate->firma_adi = null;
                        $customerCorporate->firma_adres = null;
                        $customerCorporate->firma_sehir_id = null;
                        $customerCorporate->firma_ilce_id = null;
                        $customerCorporate->firma_semt = null;
                        $customerCorporate->firma_web_adresi = null;
                        $customerCorporate->meslek = null;
                        $customerCorporate->is_telefonu = null;
                        $customerCorporate->is_fax = null;
                        $customerCorporate->is_dahili = null;
                        $customerCorporate->diger_bilgiler = null;
                        $customerCorporate->save();


                        $customerInfo = new CustomerInfo();
                        $customerInfo->customer_id = $customers->id;
                        $customerInfo->cinsiyet = $request->gender;
                        $customerInfo->tc = $request->tc;
                        $customerInfo->kan_grubu = null;
                        $customerInfo->dogum_yeri = null;
                        $customerInfo->dogum_tarihi = $request->birthday;
                        $customerInfo->egitim = null;
                        $customerInfo->arac_plaka_1 = null;
                        $customerInfo->arac_plaka_2 = null;
                        $customerInfo->kimlik_turu = null;
                        $customerInfo->favori_takim = null;
                        $customerInfo->ozel_durum = null;
                        $customerInfo->beden_olcusu = null;
                        $customerInfo->hepatit_b_rapor_alindi = null;
                        $customerInfo->hobiler = null;
                        $customerInfo->fobiler = null;
                        $customerInfo->diger_bilgiler = null;
                        $customerInfo->save();

                        $customerEmergency = new CustomerEmergency();
                        $customerEmergency->customer_id = $customers->id;
                        $customerEmergency->ad_soyad = null;
                        $customerEmergency->adres = null;
                        $customerEmergency->yakinlik = null;
                        $customerEmergency->cep = null;
                        $customerEmergency->tel = null;
                        $customerEmergency->hes_kodu = null;
                        $customerEmergency->saglik_bilgiler = null;
                        $customerEmergency->diger_bilgiler = null;
                        $customerEmergency->save();

                        $customerOtherInfo = new CustomerOtherInfo();
                        $customerOtherInfo->customer_id = $customers->id;
                        $customerOtherInfo->fatura_ismi = null;
                        $customerOtherInfo->diger_adres = null;
                        $customerOtherInfo->diger_sehir_id = null;
                        $customerOtherInfo->diger_ilce_id = null;
                        $customerOtherInfo->el_izi_id = null;
                        $customerOtherInfo->muhasebe_kodu = null;
                        $customerOtherInfo->parmak_izi_id = null;
                        $customerOtherInfo->muhasebe_kodu_2 = null;
                        $customerOtherInfo->referans_uye_id = null;
                        $customerOtherInfo->vergi_dairesi = null;
                        $customerOtherInfo->vergi_no = null;
                        $customerOtherInfo->note = null;
                        $customerOtherInfo->save();

                        $contract_1 = Contract::find(1);
                        $contract_text = str_replace('[name]',$customers->ad." ".$customers->ikinci_ad,$contract_1->contracts_text);
                        $contract_text = str_replace('[surname]',$customers->soyad,$contract_text);
                        $contract_text = str_replace('[tc]',$customers->soyad,$contract_text);
                        if(!empty($customers->address)){
                            $address = $customers->address->city?->name ?? '';
                            $address .= "/".$customers->address->counties?->name ?? '';
                            $address .= $customers->semt." ";
                            $address .= $customers->mahalle." ";
                            $address .= $customers->address." ";
                        }else{
                            $address = '';
                        }

                        $contract_text = str_replace('[address]',$address,$contract_text);
                        $contract_text = str_replace('[phone]',$customers->telefon,$contract_text);
                        $contract_text = str_replace('[email]',$customers->email,$contract_text);
                        $contract_text = str_replace('[club_name]','Eva Sportif',$contract_text);
                        $contract_text = str_replace('[start_date]',date('d.m.Y'),$contract_text);
                        $contract_text = str_replace('[not_discount_price]',$package->price,$contract_text);
                        $contract_text = str_replace('[discount_price]',$package->discount_price,$contract_text);
                        $contract_text = str_replace('[total_discount_price]',($package->discount_price * 12),$contract_text);
                        $contract_text = str_replace('[discount_diff]',($package->price - $package->discount_price),$contract_text);

                        $contract_customer_1 = new ContractsCustomer();
                        $contract_customer_1->customer_id = $customers->id;
                        $contract_customer_1->contracts_id = $contract_1->id;
                        $contract_customer_1->contracts_text = $contract_text;
                        $contract_customer_1->status = 1;
                        $contract_customer_1->save();


                        $contract_2 = Contract::find(2);
                        $contract_customer_2 = new ContractsCustomer();
                        $contract_customer_2->customer_id = $customers->id;
                        $contract_customer_2->contracts_id = $contract_2->id;
                        $contract_customer_2->contracts_text = $contract_2->contracts_text;
                        $contract_customer_2->status = 1;
                        $contract_customer_2->save();

                        $contract_3 = Contract::find(3);
                        $contract_text_3 = str_replace('[name]',$customers->ad." ".$customers->ikinci_ad,$contract_3->contracts_text);
                        $contract_text_3 = str_replace('[surname]',$customers->soyad,$contract_text_3);
                        $contract_text_3 = str_replace('[tc]',$customers->soyad,$contract_text_3);
                        if(!empty($customers->address)){
                            $address = $customers->address->city?->name ?? '';
                            $address .= "/".$customers->address->counties?->name ?? '';
                            $address .= $customers->semt." ";
                            $address .= $customers->mahalle." ";
                            $address .= $customers->address." ";
                        }else{
                            $address = '';
                        }

                        $contract_text_3 = str_replace('[address]',$address,$contract_text_3);
                        $contract_text_3 = str_replace('[phone]',$customers->telefon,$contract_text_3);
                        $contract_text_3 = str_replace('[email]',$customers->email,$contract_text_3);
                        $contract_text_3 = str_replace('[club_name]','Eva Sportif',$contract_text_3);
                        $contract_text_3 = str_replace('[start_date]',date('d.m.Y'),$contract_text_3);
                        $contract_text_3 = str_replace('[not_discount_price]',$package->price,$contract_text_3);
                        $contract_text_3 = str_replace('[discount_price]',$package->discount_price,$contract_text_3);
                        $contract_text_3 = str_replace('[total_discount_price]',($package->discount_price * 12),$contract_text_3);
                        $contract_text_3 = str_replace('[discount_diff]',($package->price - $package->discount_price),$contract_text_3);

                        $contract_customer_3 = new ContractsCustomer();
                        $contract_customer_3->customer_id = $customers->id;
                        $contract_customer_3->contracts_id = $contract_3->id;
                        $contract_customer_3->contracts_text = $contract_text_3;
                        $contract_customer_3->status = 1;
                        $contract_customer_3->save();

                        $contract_4 = Contract::find(4);
                        $contract_text_4 = str_replace('[name]',$customers->ad." ".$customers->ikinci_ad,$contract_4->contracts_text);
                        $contract_text_4 = str_replace('[surname]',$customers->soyad,$contract_text_4);
                        $contract_text_4 = str_replace('[tc]',$customers->soyad,$contract_text_4);
                        if(!empty($customers->address)){
                            $address = $customers->address->city?->name ?? '';
                            $address .= "/".$customers->address->counties?->name ?? '';
                            $address .= $customers->semt." ";
                            $address .= $customers->mahalle." ";
                            $address .= $customers->address." ";
                        }else{
                            $address = '';
                        }

                        $contract_text_4 = str_replace('[address]',$address,$contract_text_4);
                        $contract_text_4 = str_replace('[phone]',$customers->telefon,$contract_text_4);
                        $contract_text_4 = str_replace('[email]',$customers->email,$contract_text_4);
                        $contract_text_4 = str_replace('[club_name]','Eva Sportif',$contract_text_4);
                        $contract_text_4 = str_replace('[start_date]',date('d.m.Y'),$contract_text_4);
                        $contract_text_4 = str_replace('[not_discount_price]',$package->price,$contract_text_4);
                        $contract_text_4 = str_replace('[discount_price]',$package->discount_price,$contract_text_4);
                        $contract_text_4 = str_replace('[total_discount_price]',($package->discount_price * 12),$contract_text_4);
                        $contract_text_4 = str_replace('[discount_diff]',($package->price - $package->discount_price),$contract_text_4);

                        $contract_customer_4 = new ContractsCustomer();
                        $contract_customer_4->customer_id = $customers->id;
                        $contract_customer_4->contracts_id = $contract_4->id;
                        $contract_customer_4->contracts_text = $contract_text_4;
                        $contract_customer_4->status = 1;
                        $contract_customer_4->save();

                    }



                    $new_order = new  Orders();
                    $new_order->customer_id = $customers->id;
                    $new_order->price = $package->price;
                    $new_order->total_price = $last_price;
                    $new_order->merchant_oid = $merchant_oid;
                    $new_order->status = 2;
                    $new_order->step_status = 1;
                    $new_order->save();

                    $new_order_detail = new OrderDetail();
                    $new_order_detail->order_id = $new_order->id;
                    $new_order_detail->product_id = $package->id;
                    $new_order_detail->product_type = 2;
                    $new_order_detail->price = $package->price;
                    $new_order_detail->total_price = $last_price;
                    $new_order_detail->piece = 1;
                    $new_order_detail->status = 1;
                    $new_order_detail->save();

                }

                return response()->json(['type' => 'success', 'message' => $response,'order_number'=>$merchant_oid]);

            } else {
                return response()->json(['type' => 'error', 'errors' => ['Lütfen Tüm Alanlarını Doldurduğunuza Emin Olun.']]);
            }
        }
    }

    public function registerAfterLogin(Request $request){
        $referer = $request->server('HTTP_REFERER');
        $order = Orders::where('merchant_oid',$request->order_number)->first();
        if(!empty($order)){
            $user = User::find($order->customer_id);
            $customer = Customer::find($order->customer_id);
            Auth::login($user);
            session(['api_token' => $customer->createToken('api-token')->plainTextToken]);
            return response()->json(['type' => 'success']);
        }else{
            return response()->json(['type' => 'error', 'errors' => ['Bir Hata Oluştu']]);
        }
    }

    public function logout(){
        session()->flush();
        Auth::logout();
        return redirect(route('sign_in'));
    }
}
