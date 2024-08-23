<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    public function getCategory()
    {
        return $this->hasOne(ProductCategory::class,'id','category_id');
    }

    public function getStockCheck(){
        $order = OrderDetail::where('product_id',$this->id)->sum('piece');
        return ($this->quantity - $order);
    }
}
