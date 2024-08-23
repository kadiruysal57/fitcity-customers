<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "orders";

    public function orderProductOne()
    {
        return $this->hasOne(OrderDetail::class,'order_id','id');
    }
    public function orderProducts()
    {
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }
    public function StepStatus()
    {
        return $this->hasOne(StepStatus::class,'id','step_status');
    }
}
