<?php

namespace App\Http\Controllers;

use App\Models\Basket;
use App\Models\Cities;
use App\Models\Counties;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function index(){
        $data['products'] = Product::where('quantity','>',0)->get();
        return view('Kpanel.products.index')->with($data);
    }
    public function basket_list(){
        $data['basket'] = Basket::where('customer_id', Auth::user()->id)
            ->get();

        $result = makeApiRequest('https://api.fitcity.com.tr/api/card_list',session('api_token'));
        $data['card_list'] = json_decode($result['data']);
        $data['city'] = Cities::where('status',1)->get();
        $data['counties_delivery'] = collect();
        if(!empty(Auth::user()->getAddressDelivery) && !empty(Auth::user()->getAddressDelivery->sehir_id)){
            $data['counties_delivery'] = Counties::where('city_id',Auth::user()->getAddressDelivery->sehir_id)->get();
        }

        return view('Kpanel.products.basket')->with($data);
    }

    public function add_basket(Request $request){
        $product = Product::find($request->id);
        if(!empty($product)){
            if($product->getStockCheck() > 0){
                $basket_check = Basket::where('customer_id',Auth::user()->id)->where('product_id',$request->id)->first();
                if(!empty($basket_check)){
                    $total_piece = $basket_check->piece + 1;
                    if($product->getStockCheck() >= $total_piece){
                        $basket_check->total_price = $basket_check->price * ($basket_check->piece + 1);
                        $basket_check->piece = $total_piece;
                        $basket_check->save();
                        return response()->json(['type'=>'true','message'=>'Ürün Sepete Eklendi.']);
                    }else{
                        return response()->json(['type'=>'false','message'=>'Mevcut Stok:'.$product->getStockCheck().' Daha Fazla Ekleyemezsiniz.']);
                    }
                }else{
                    $new_basket = New Basket();
                    $new_basket->customer_id = Auth::user()->id;
                    $new_basket->product_id = $request->id;
                    $new_basket->price = $product->price;
                    $new_basket->total_price = $product->price;
                    $new_basket->piece = 1;
                    $new_basket->type_basket = 1;
                    $new_basket->save();
                    return response()->json(['type'=>'true','message'=>'Ürün Sepete Eklendi.']);

                }
            }else{
                return response()->json(['type'=>'false','message'=>'Ürün Stoklarımızda Mevcut Değil']);
            }
        }else{
            return response()->json(['type'=>'false','message'=>'Bir Hata Oluştu Daha Sonra Tekrar Deneyiniz.']);
        }
    }
    public function delete_basket(Request $request){
        $basket_check = Basket::find($request->basket_id);
        $basket_count = Basket::where('customer_id',Auth::user()->id)->count();
        if(!empty($basket_check)){
            $basket_check->delete();
            $basket_count = Basket::where('customer_id',Auth::user()->id)->count();

            return response()->json(['type'=>'true','message'=>'Ürün Sepetten Silindi.','basket_count'=>$basket_count]);
        }else{
            return response()->json(['type'=>'false','message'=>'Bir Hata Oluştu Daha Sonra Tekrar Deneyiniz.','basket_count'=>$basket_count]);
        }
    }
    public function update_basket(Request $request){
        $basket_check = Basket::find($request->basket_id);

        if(!empty($basket_check)){
            $product = Product::find($basket_check->product_id);
            if($product->getStockCheck() > 0){
                $total_piece = $request->piece;

                if($product->getStockCheck() >= $total_piece){
                    $basket_check->total_price = $basket_check->price * $request->piece;
                    $basket_check->piece = $total_piece;
                    $basket_check->save();
                    $basket_product_total_price = Basket::where('product_id',$basket_check->product_id)
                        ->where('customer_id',Auth::user()->id)->sum('total_price');
                    $basket_total_price = Basket::where('customer_id',Auth::user()->id)->sum('total_price');
                    return response()->json(['type'=>'true','message'=>'Ürün Güncellendi.','basket_product_total_price'=>number_format($basket_product_total_price, 2, ',', '.').'₺','basket_total_price'=>number_format($basket_total_price, 2, ',', '.').'₺']);
                }else{
                    return response()->json(['type'=>'false','message'=>'Mevcut Stok:'.$product->getStockCheck().' Daha Fazla Ekleyemezsiniz.']);
                }
            }else{
                return response()->json(['type'=>'false','message'=>'Bir Hata Oluştu Daha Sonra Tekrar Deneyiniz. ']);
            }

        }else{
            return response()->json(['type'=>'false','message'=>'Bir Hata Oluştu Daha Sonra Tekrar Deneyiniz. 1']);
        }
    }

}
