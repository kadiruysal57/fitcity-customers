<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Model
{
    use HasFactory,HasApiTokens,Notifiable, SoftDeletes;

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];
    public function danisman(){
        return $this->hasOne(Customer::class,'id','danisman_id');
    }
    public function address(){
        return $this->hasOne(CustomerAddress::class,'customer_id','id');
    }
    public function approve(){
        return $this->hasOne(CustomerApprove::class,'customer_id','id');
    }
    public function infos(){
        return $this->hasOne(CustomerInfo::class,'customer_id','id');
    }
}
