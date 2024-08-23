<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerBuyLessons extends Model
{
    use HasFactory;

    protected $table = "customer_buy_lesson";

    public function personel(){
        return $this->hasOne(UserAdmin::class,'id','personel_id');
    }
}
