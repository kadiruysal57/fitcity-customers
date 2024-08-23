<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerAddress extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'adres', 'sehir_id', 'ilce_id', 'mahalle', 'semt',
    ];

    protected $hidden = [
        'customer_id',
        'created_at',
        'updated_at',
    ];


    public function city(){
        return $this->hasOne(Cities::class,'id','sehir_id');
    }
    public function counties(){
        return $this->hasOne(Counties::class,'id','ilce_id');
    }
}
