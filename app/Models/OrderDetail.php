<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ="order_detail";

    public function Product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
    public function Packages()
    {
        return $this->hasOne(Packages::class,'id','product_id');
    }
}
