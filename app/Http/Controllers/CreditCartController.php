<?php

namespace App\Http\Controllers;

use App\Models\OrderRefund;
use App\Models\Orders;

class CreditCartController extends Controller
{
    public function CreditCardList(){
        if(!empty($_GET['return_url'])){
            session(['return_url' => $_GET['return_url']]);
        }
        if(!empty($_GET['type']) && !empty($_GET['order_number']) && $_GET['type'] == 'success'){
            $order = Orders::where('merchant_oid',$_GET['order_number'])->first();
            if (!empty($order) && $order->orderProductOne->product_id == 5 && $order->orderProductOne->product_type == 2) {
                $order_refund = OrderRefund::where('merchant_oid',$order->merchant_oid)->first();
                if(empty($order_refund)){
                    $refund =  OrderRefund($order->merchant_oid,$order->total_price);
                }
                if(!empty(session('return_url'))){
                    return redirect(session('return_url'));
                }
            }
        }
        if(!empty($_GET['type']) && !empty($_GET['order_number']) && $_GET['type'] == 'error'){
            if(!empty($_GET['order_number'])){
                $order = Orders::where('merchant_oid',$_GET['order_number'])->first();
                $order->payment_error = '';
                $order->status = 3;
                $order->save();
            }
        }

        $result = makeApiRequest('https://api.evagym.com/api/card_list',session('api_token'));
        if($result['success'] == 'true'){
            $data['credits'] = json_decode($result['data']);
            return view('Kpanel.credits.card_list')->with($data);
        }else{
            return view('Kpanel.405');
        }
    }

}
