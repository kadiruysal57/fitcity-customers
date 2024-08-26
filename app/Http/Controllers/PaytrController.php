<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Contract;
use App\Models\ContractsCustomer;
use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\CustomerPackageRepeat;
use App\Models\CustomerPackages;
use App\Models\OrderDetail;
use App\Models\OrderRefund;
use App\Models\Orders;
use App\Models\Packages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaytrController extends Controller
{

    public function CardSave(Request $request){


        $merchant_id = env('PAYTR_MERCHANT_ID');
        $merchant_key = env('PAYTR_MERCHANT_KEY');
        $merchant_salt = env('PAYTR_MERCHANT_SALT');
        $merchant_oid = rand();
        $merchant_ok_url = route('CreditCardList',['type'=>'success','order_number' => $merchant_oid]);
        $merchant_fail_url = route('CreditCardList',['type'=>'error','order_number' => $merchant_oid]);

        $user_basket = json_encode(array(
            array("Kart Kaydetme", "1.00", 1),
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
        $email = $request->user()->email ?? '1111@gmail.com';
        $payment_amount = 1.00;
        $currency = "TL";
        $payment_type = "card";
        /*$no_installment = 0;
        $max_installment = 0;*/
        $installment_count = 0;


        /*$hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $payment_type . $installment_count. $currency. $test_mode. $non_3d;
        $token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));*/


        $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $payment_type . $installment_count. $currency. $test_mode. $non_3d;
        $token = base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));

        $utoken = Auth::user()->utoken ?? '';



        $post_url = "https://www.paytr.com/odeme";

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
            "user_name" => $request->user()->name,
            "user_address" => "11111 test",
            "user_phone" => $request->user()->telefon,
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
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Bu satır, SSL sertifikası doğrulamasını devre dışı bırakır. Canlı sistemde önerilmez!

        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);


        $new_order = new  Orders();
        $new_order->customer_id = $request->user()->id;
        $new_order->price = 1;
        $new_order->total_price = 1;
        $new_order->merchant_oid = $merchant_oid;
        $new_order->status = 2;
        $new_order->step_status = 4;
        $new_order->save();

        $new_order_detail = New OrderDetail();
        $new_order_detail->order_id = $new_order->id;
        $new_order_detail->product_id = 5;
        $new_order_detail->product_type = 2;
        $new_order_detail->price = 1;
        $new_order_detail->total_price = 1;
        $new_order_detail->piece = 1;
        $new_order_detail->status = 1;
        $new_order_detail->save();

        return response()->json(['type'=>'success','message'=>$response]);

    }
    public function PaytrReturnCallback(Request $request){
        $order = Orders::where('merchant_oid',$_GET['order_number'])->first();
        if (!empty($order) && $order->orderProductOne->product_id == 5 && $order->orderProductOne->product_type == 2) {
            $order_refund = OrderRefund::where('merchant_oid',$order->merchant_oid)->first();
            if(empty($order_refund)){
                $refund =  $this->OrderRefund($order->merchant_oid,$order->total_price);
            }
        }

        return view('credit-card-page.success');
    }
    public function PaymentError(Request $request){
        if(!empty($_GET['order_number'])){
            $order = Orders::where('merchant_oid',$_GET['order_number'])->first();
            $order->payment_error = $request->fail_message;
            $order->status = 3;
            $order->save();
        }
        $data['fail_message'] = $request->fail_message;
        return view('credit-card-page.error')->with($data);
    }
    public function PaytrCallback(Request $request){

        $post = $_POST;

       $merchant_key = env('PAYTR_MERCHANT_KEY');
        $merchant_salt = env('PAYTR_MERCHANT_SALT');

        $hash = base64_encode( hash_hmac('sha256', $post['merchant_oid'].$merchant_salt.$post['status'].$post['total_amount'], $merchant_key, true) );

        if( $hash != $post['hash'] )
            die('PAYTR notification failed: bad hash');


        if( $post['status'] == 'success' ) {
            $order = Orders::where('merchant_oid',$post['merchant_oid'])->first();
            if(!empty($order)){
                $order->status = 1;
                $order->save();

                $customer = Customer::find($order->customer_id);
                if(!empty($customer)){
                    $customer->utoken = $post['utoken'] ?? 'utoken gelmedi';
                    $customer->save();
                }

            }



        } else { ## Ödemeye Onay Verilmedi

            $order = Orders::where('merchant_oid',$post['merchant_oid'])->first();
            if(!empty($order)){
                $order->status = 3;
                $order->payment_error = $post['failed_reason_code']." - ".$post['failed_reason_msg'];
                $order->save();
            }



        }


        echo "OK";
        exit;
    }
    public function StartPaymentPackage(Request $request){

        $packages = Packages::find($request->package_id);
        if(!empty($packages)){
            $merchant_id = env('PAYTR_MERCHANT_ID');
            $merchant_key = env('PAYTR_MERCHANT_KEY');
            $merchant_salt = env('PAYTR_MERCHANT_SALT');
            $merchant_oid = rand();

            $merchant_ok_url = route('MembershipInformation',['type'=>'success','order_number' => $merchant_oid]);
            $merchant_fail_url = route('MembershipInformation',['type'=>'error','order_number' => $merchant_oid]);

            $user_basket = htmlentities(json_encode(array(
                array($packages->name, $packages->price, 1),
            )));




            $test_mode="0";

            //3d'siz işlem
            $non_3d="1";

            $non3d_test_failed="0";

            if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                $ip = $_SERVER["HTTP_CLIENT_IP"];
            } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }



            $user_ip = $ip;
            $email = $request->user()->email ?? '1111@gmail.com';
            $payment_amount = $packages->discount_price;
            $currency = "TL";
            $payment_type = "card";
            $no_installment = 0;
            $max_installment = 0;
            $installment_count = 0;


            $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $payment_type . $installment_count. $currency. $test_mode. $non_3d;
            $token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));

            $post_url = "https://www.paytr.com/odeme";
            $recurring_payment = "0";
            $utoken = $request->user()->utoken ?? '';
            $ctoken = $request->ctoken;


            $fields = [
                'merchant_id' => $merchant_id,
                'user_ip' => $user_ip,
                'merchant_oid' => $merchant_oid,
                'email' => $email,
                'payment_type' => $payment_type,
                'payment_amount' => $payment_amount,
                'installment_count' => "0",
                'no_installment' => $no_installment,
                'max_installment' => $max_installment,
                'currency' => $currency,
                'test_mode' => $test_mode,
                'non_3d' => $non_3d,
                'merchant_ok_url' => $merchant_ok_url,
                'merchant_fail_url' => $merchant_fail_url,
                'user_name' => Auth::user()->name,
                'user_address' => "",
                'user_phone' => Auth::user()->telefon ?? '',
                'user_basket' => $user_basket,
                'debug_on' => "0",
                'paytr_token' => $token,
                'non3d_test_failed' => $non3d_test_failed,
                'utoken' => $utoken,
                'ctoken' => $ctoken,
                'recurring_payment' => $recurring_payment
            ];

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $post_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);

            if(curl_errno($ch)){
                echo 'Curl error: ' . curl_error($ch);
            }

            curl_close ($ch);

            if(empty($response)){
                $new_order = new  Orders();
                $new_order->customer_id = $request->user()->id;
                $new_order->price = $packages->price;
                $new_order->total_price = $packages->discount_price;
                $new_order->merchant_oid = $merchant_oid;
                $new_order->status = 1;
                $new_order->step_status = 4;
                $new_order->save();

                $new_order_detail = New OrderDetail();
                $new_order_detail->order_id = $new_order->id;
                $new_order_detail->product_id = $packages->id;
                $new_order_detail->product_type = 2;
                $new_order_detail->price = $packages->price;
                $new_order_detail->total_price = $packages->discount_price;
                $new_order_detail->piece = 1;
                $new_order_detail->status = 1;
                $new_order_detail->save();

                $customer_package = New CustomerPackages();
                $customer_package->customer_id = Auth::user()->id;
                $customer_package->packages_id = $packages->id;
                $customer_package->start_date = date('Y-m-d');
                $customer_package->finish_date = date('Y-m-d', strtotime('+'.$packages->usage_time.'days'));
                $customer_package->price = $packages->price;
                $customer_package->discount_price = $packages->discount_price;
                $customer_package->branch_id = 1;
                $customer_package->status = 1;
                $customer_package->save();

                $new_customer_package_repeat = New CustomerPackageRepeat();
                $new_customer_package_repeat->customer_packages_id = $customer_package->id;
                $new_customer_package_repeat->status = 1;
                $new_customer_package_repeat->save();

                if (env("SMS_ACTIVE")) {
                    $gsm = str_replace(['(', ')', ' '], ['', '', ''], $request->user()->telefon);
                    $message = 'Fitcity ailesine hoş geldiniz.';
                    if (substr($gsm, 0, 1) === '0') {
                        $gsm = substr($gsm, 1);
                    }
                    $xml = '<?xml version="1.0"?>
                            <mainbody>
                               <header>
                                   <usercode>' . env("SMS_USER_CODE") . '</usercode>
                                   <password>' . env("SMS_USER_PASSWORD") . '</password>
                                   <msgheader>' . env("SMS_HEADER") . '</msgheader>
                                   <appkey>' . env("SMS_USER_CODE") . '</appkey>
                               </header>
                               <body>
                                   <msg>
                                       ' . $message . '
                                   </msg>
                                   <no>' . $gsm . '</no>
                               </body>
                            </mainbody>';
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, 'https://api.netgsm.com.tr/sms/send/otp');
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
                    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
                    $result = curl_exec($ch);

                }

                $customers = Customer::find(Auth::user()->id);
                $package = $packages;
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





            return response()->json(['type'=>'true','response'=>$response]);
        }else{
            return response()->json(['type'=>'false','message'=>'Paket Tanımlı Değil.']);

        }


    }
    public function StartPaymentCancelledPackage(Request $request){
        $customer_package = CustomerPackages::find($request->cancelled_package_id);
        if(!empty($customer_package)){
            $packages = Packages::find($customer_package->packages_id);
            if(!empty($packages)){

                $merchant_id = env('PAYTR_MERCHANT_ID');
                $merchant_key = env('PAYTR_MERCHANT_KEY');
                $merchant_salt = env('PAYTR_MERCHANT_SALT');
                $merchant_oid = rand();

                $merchant_ok_url = route('MembershipInformation',['type'=>'success','order_number' => $merchant_oid]);
                $merchant_fail_url = route('MembershipInformation',['type'=>'error','order_number' => $merchant_oid]);


                $start_date = strtotime($customer_package->start_date);
                $finish_date = strtotime($customer_package->finish_date);

                $year_diff_in_months = (date('Y', $finish_date) - date('Y', $start_date)) * 12;
                $month_diff = date('m', $finish_date) - date('m', $start_date);
                $total_month_diff = $year_diff_in_months + $month_diff;

                $discount_price_diff = $customer_package->price - $customer_package->discount_price;
                $pay_discount_price_diff = $discount_price_diff * $total_month_diff;

                $user_basket = htmlentities(json_encode(array(
                    array($packages->name." İptal Miktarı", $pay_discount_price_diff, 1),
                )));




                $test_mode="0";

                //3d'siz işlem
                $non_3d="1";

                $non3d_test_failed="0";

                if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } else {
                    $ip = $_SERVER["REMOTE_ADDR"];
                }



                $user_ip = $ip;
                $email = $request->user()->email ?? '1111@gmail.com';
                $payment_amount = $pay_discount_price_diff;
                $currency = "TL";
                $payment_type = "card";
                $no_installment = 0;
                $max_installment = 0;
                $installment_count = 0;


                $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $payment_type . $installment_count. $currency. $test_mode. $non_3d;
                $token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));

                $post_url = "https://www.paytr.com/odeme";
                $recurring_payment = "0";
                $utoken = $request->user()->utoken ?? '';
                $ctoken = $request->ctoken;


                $fields = [
                    'merchant_id' => $merchant_id,
                    'user_ip' => $user_ip,
                    'merchant_oid' => $merchant_oid,
                    'email' => $email,
                    'payment_type' => $payment_type,
                    'payment_amount' => $payment_amount,
                    'installment_count' => "0",
                    'no_installment' => $no_installment,
                    'max_installment' => $max_installment,
                    'currency' => $currency,
                    'test_mode' => $test_mode,
                    'non_3d' => $non_3d,
                    'merchant_ok_url' => $merchant_ok_url,
                    'merchant_fail_url' => $merchant_fail_url,
                    'user_name' => Auth::user()->name,
                    'user_address' => "test",
                    'user_phone' => Auth::user()->telefon,
                    'user_basket' => $user_basket,
                    'debug_on' => "0",
                    'paytr_token' => $token,
                    'non3d_test_failed' => $non3d_test_failed,
                    'utoken' => $utoken,
                    'ctoken' => $ctoken,
                    'recurring_payment' => $recurring_payment
                ];

                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $post_url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if(curl_errno($ch)){
                    echo 'Curl error: ' . curl_error($ch);
                }

                curl_close ($ch);

                if(empty($response)){
                    $order = New Orders();
                    $order->customer_id = Auth::user()->id;
                    $order->price = $pay_discount_price_diff;
                    $order->total_price = $pay_discount_price_diff;
                    $order->merchant_oid = $merchant_oid;
                    $order->status = 2;
                    $order->step_status = 1;
                    $order->save();

                    $customer_package_repeat = CustomerPackageRepeat::where('customer_packages_id',$customer_package->id)->first();
                    $customer_package_repeat->status = 2;
                    $customer_package_repeat->cancelled_price = $pay_discount_price_diff;
                    $customer_package_repeat->save();

                }





                return response()->json(['type'=>'true','response'=>$response]);
            }else{
                return response()->json(['type'=>'false','response'=>'Paket Tanımlı Değil.']);
            }
        }else{
            return response()->json(['type'=>'false','response'=>'Paket Tanımlı Değil.']);
        }



    }
    public function StartPaymentBasket(Request $request){
        $validator_array = array(
            'city_id_delivery' => 'required',
            'counties_id_delivery' => 'required',
            'semt_delivery' => 'required',
            'mahalle_delivery' => 'required',
            'address_delivery' => 'required',
            'ctoken'=>'required'
        );
        $validator_message = array(
            'city_id_delivery.required' => 'Teslim Adresindeki Şehir Bilgilerini Kontrol Ediniz.',
            'counties_id_delivery.required' => 'Teslim Adresideki İlçe Bilgilerini Kontrol Ediniz.',
            'semt_delivery.required' => 'Teslim Adresindeki Semt Bilgilerini Kontrol Ediniz.',
            'mahalle_delivery.required' => 'Teslim Adresideki Mahalle Bilgilerini Kontrol Ediniz.',
            'address_delivery.required' => 'Teslim Adresindeki Adres Bilgilerini Kontrol Ediniz.',
            'ctoken.required' => 'Lütfen Kart Seçiniz.',
        );
        if(empty($request->delivery_invoice_same) && $request->delivery_invoice_same != "delivery_invoice_same"){
            $validator_array['city_id_invoice'] = 'required';
            $validator_array['counties_id_invoice'] = 'required';
            $validator_array['semt_invoice'] = 'required';
            $validator_array['mahalle_invoice'] = 'required';
            $validator_array['address_invoice'] = 'required';

            $validator_message['city_id_invoice.required'] = 'Fatura Adresindeki Şehir Bilgilerini Kontrol Ediniz.';
            $validator_message['counties_id_invoice.required'] = 'Fatura Adresindeki İlçe Bilgilerini Kontrol Ediniz.';
            $validator_message['semt_invoice.required'] = 'Fatura Adresi Bilgilerininde Semt Kontrol Ediniz.';
            $validator_message['mahalle_invoice.required'] = 'Fatura Adresi Bilgilerininde Mahalle Kontrol Ediniz.';
            $validator_message['address_invoice.required'] = 'Fatura Adresi Bilgilerinindeki Adres Kontrol Ediniz.';
        }
        $validator = Validator::make($request->all(),$validator_array,$validator_message);
        if ($validator->passes()) {
            $basket = Basket::where('customer_id',$request->user()->id)->with(['getProduct'])->get();
            if(!empty($basket)){
                $merchant_id = env('PAYTR_MERCHANT_ID');
                $merchant_key = env('PAYTR_MERCHANT_KEY');
                $merchant_salt = env('PAYTR_MERCHANT_SALT');
                $merchant_oid = rand();
                $merchant_ok_url = route('payment_success_no_session', ['type' => 'success', 'order_number' => $merchant_oid]);
                $merchant_fail_url = route('payment_error_no_session', ['type' => 'error', 'order_number' => $merchant_oid]);

                $basket_array = array();
                foreach($basket as $b){
                    $basket_array[] = array(
                        $b->getProduct->name,
                        $b->total_price,
                        $b->piece
                    );
                }
                $user_basket = htmlentities(json_encode($basket_array));



                $test_mode="0";

                //3d'siz işlem
                $non_3d="1";

                $non3d_test_failed="0";

                if( isset( $_SERVER["HTTP_CLIENT_IP"] ) ) {
                    $ip = $_SERVER["HTTP_CLIENT_IP"];
                } elseif( isset( $_SERVER["HTTP_X_FORWARDED_FOR"] ) ) {
                    $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
                } else {
                    $ip = $_SERVER["REMOTE_ADDR"];
                }

                $basket_total_amount = Basket::where('customer_id',$request->user()->id)->sum('total_price');

                $user_ip = $ip;
                $email = Auth::user()->email ?? '1111@gmail.com';
                $payment_amount = $basket_total_amount;
                $currency = "TL";
                $payment_type = "card";
                $no_installment = 0;
                $max_installment = 0;
                $installment_count = 0;


                $hash_str = $merchant_id . $user_ip . $merchant_oid . $email . $payment_amount . $payment_type . $installment_count. $currency. $test_mode. $non_3d;
                $token=base64_encode(hash_hmac('sha256',$hash_str.$merchant_salt,$merchant_key,true));

                $post_url = "https://www.paytr.com/odeme";
                $recurring_payment = "0";
                $utoken = Auth::user()->utoken ?? '';
                $ctoken = $request->ctoken;
                $fields = [
                    'merchant_id' => $merchant_id,
                    'user_ip' => $user_ip,
                    'merchant_oid' => $merchant_oid,
                    'email' => $email,
                    'payment_type' => $payment_type,
                    'payment_amount' => $payment_amount,
                    'installment_count' => "0",
                    'no_installment' => $no_installment,
                    'max_installment' => $max_installment,
                    'currency' => $currency,
                    'test_mode' => $test_mode,
                    'non_3d' => $non_3d,
                    'merchant_ok_url' => $merchant_ok_url,
                    'merchant_fail_url' => $merchant_fail_url,
                    'user_name' => Auth::user()->name,
                    'user_address' => $request->address_delivery ?? '',
                    'user_phone' => Auth::user()->telefon,
                    'user_basket' => $user_basket,
                    'debug_on' => "0",
                    'paytr_token' => $token,
                    'non3d_test_failed' => $non3d_test_failed,
                    'utoken' => $utoken,
                    'ctoken' => $ctoken,
                    'recurring_payment' => $recurring_payment
                ];
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL, $post_url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if(curl_errno($ch)){
                    echo 'Curl error: ' . curl_error($ch);
                }

                curl_close ($ch);

                // burada gelen değere göre order'a eklenecek.
                if (!empty($response)) {
                    return response()->json(['type' => 'error', 'response' => $response]);
                }else{
                    $new_order = new  Orders();
                    $new_order->customer_id = $request->user()->id;
                    $new_order->price = $basket_total_amount;
                    $new_order->total_price = $basket_total_amount;
                    $new_order->merchant_oid = $merchant_oid;
                    $new_order->status = 1;
                    $new_order->step_status = 4;
                    $new_order->save();

                    foreach($basket as $b){
                        $new_order_detail = New OrderDetail();
                        $new_order_detail->order_id = $new_order->id;
                        $new_order_detail->product_id = $b->getProduct->id;
                        $new_order_detail->product_type = 1;
                        $new_order_detail->price = $b->getProduct->price;
                        $new_order_detail->total_price = $b->total_price;
                        $new_order_detail->piece = $b->piece;
                        $new_order_detail->status = 1;
                        $new_order_detail->save();
                    }

                    if(!empty($request->delivery_address_id)){
                        $delivery_address = CustomerAddress::find($request->delivery_address_id);
                    }else{
                        $delivery_address = New CustomerAddress();
                        $delivery_address->customer_id = Auth::user()->id;
                    }
                    $delivery_address->adres = $request->address_delivery;
                    $delivery_address->sehir_id = $request->city_id_delivery;
                    $delivery_address->ilce_id = $request->counties_id_delivery;
                    $delivery_address->semt = $request->semt_delivery;
                    $delivery_address->mahalle = $request->mahalle_delivery;
                    $delivery_address->address_type = 1;
                    $delivery_address->save();
                    if(empty($request->delivery_invoice_same) && $request->delivery_invoice_same != "delivery_invoice_same"){
                        if(!empty($request->invoice_address_id)){
                            $invoice_address = CustomerAddress::find($request->invoice_address_id);
                        }else{
                            $invoice_address = New CustomerAddress();
                            $invoice_address->customer_id = Auth::user()->id;
                        }
                        $invoice_address->adres = $request->address_invoice;
                        $invoice_address->sehir_id = $request->city_id_invoice;
                        $invoice_address->ilce_id = $request->counties_id_invoice;
                        $invoice_address->semt = $request->semt_invoice;
                        $invoice_address->mahalle = $request->mahalle_invoice;
                        $invoice_address->address_type = 2;
                        $invoice_address->save();
                    }else{
                        if(!empty($request->invoice_address_id)){
                            $invoice_address = CustomerAddress::find($request->invoice_address_id);
                        }else{
                            $invoice_address = New CustomerAddress();
                            $invoice_address->customer_id = Auth::user()->id;
                        }
                        $invoice_address->adres = $delivery_address->adres;
                        $invoice_address->sehir_id = $delivery_address->sehir_id;
                        $invoice_address->ilce_id = $delivery_address->ilce_id;
                        $invoice_address->semt = $delivery_address->semt;
                        $invoice_address->mahalle = $delivery_address->mahalle;
                        $invoice_address->address_type = 2;
                        $invoice_address->save();
                    }
                }
                $basket_delete = Basket::where('customer_id',$request->user()->id)->delete();
                return response()->json(['type'=>'true','order_number'=>$merchant_oid,'response'=>$response]);
            }else{
                return response()->json(['type'=>'false','message'=>'Paket Tanımlı Değil.']);

            }
        } else {
            return response()->json(['type'=>'error','error' => $validator->errors()->all()]);
        }



    }
    public function CardList(Request $request){

        $merchant_id = env('PAYTR_MERCHANT_ID');
        $merchant_key = env('PAYTR_MERCHANT_KEY');
        $merchant_salt = env('PAYTR_MERCHANT_SALT');

        $utoken = Auth::user()->utoken ?? '';

        $hash_str = $utoken . $merchant_salt;
        $paytr_token=base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));
        $post_vals=array(
            'merchant_id'=>$merchant_id,
            'utoken'=>$utoken,
            'paytr_token'=>$paytr_token
        );

        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/capi/list");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);



        $result = @curl_exec($ch);

        if(curl_errno($ch))
            return response()->json(['type'=>'false','message'=>'PAYTR CAPI List connection error. err:'.curl_error($ch)]);
        curl_close($ch);

        $result=json_decode($result,1);

        return response()->json(['type'=>'true','save_card'=>$result]);

    }
    public function CardDelete(Request $request){


        $merchant_id = env('PAYTR_MERCHANT_ID');
        $merchant_key = env('PAYTR_MERCHANT_KEY');
        $merchant_salt = env('PAYTR_MERCHANT_SALT');

        $utoken = Auth::user()->utoken ?? '';
        $ctoken = $request->ctoken ?? '';

        $hash_str = $ctoken . $utoken . $merchant_salt;
        $paytr_token=base64_encode(hash_hmac('sha256', $hash_str, $merchant_key, true));
        $post_vals=array(
            'merchant_id'=>$merchant_id,
            'ctoken'=>$ctoken,
            'utoken'=>$utoken,
            'paytr_token'=>$paytr_token
        );

        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/capi/delete");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);



        $result = @curl_exec($ch);

        if(curl_errno($ch))
            return response()->json(['type'=>'false','message'=>'PAYTR CAPI List connection error. err:'.curl_error($ch)]);

        curl_close($ch);

        $result=json_decode($result,1);

        if($result['status']=='success')
            return response()->json(['type'=>'true','message'=>'Kart Silindi.']);
        else
            return response()->json(['type'=>'false','message'=>'PAYTR CAPI Delete failed. Error:'.$result['err_msg']]);
    }
    public function OrderRefund($merchant_oid,$return_amount){
        $merchant_id = env('PAYTR_MERCHANT_ID');
        $merchant_key = env('PAYTR_MERCHANT_KEY');
        $merchant_salt = env('PAYTR_MERCHANT_SALT');
        #
        $merchant_oid   = $merchant_oid;
        #
        $return_amount  = $return_amount;

        $paytr_token=base64_encode(hash_hmac('sha256',$merchant_id.$merchant_oid.$return_amount.$merchant_salt,$merchant_key,true));

        $post_vals=array(
            'merchant_id'=>$merchant_id,
            'merchant_oid'=>$merchant_oid,
            'return_amount'=>$return_amount,
            'paytr_token'=>$paytr_token
        );

        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://www.paytr.com/odeme/iade");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1) ;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_vals);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 90);

        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = @curl_exec($ch);

        if(curl_errno($ch))
        {
            echo curl_error($ch);
            curl_close($ch);
            exit;
        }

        curl_close($ch);

        $result=json_decode($result,1);



        if($result['status']=='success')
        {
            $order = Orders::where('merchant_oid',$result['merchant_oid'])->first();
            if(!empty($order)){
                $order->status = 4;
                $order->step_status = 1;
                $order->save();
            }

            $new_order_refund = New OrderRefund();
            $new_order_refund->status = $result['status'];
            $new_order_refund->is_test = $result['is_test'];
            $new_order_refund->merchant_oid = $result['merchant_oid'];
            $new_order_refund->return_amount = $result['return_amount'];
            $new_order_refund->save();
        }

    }

}
