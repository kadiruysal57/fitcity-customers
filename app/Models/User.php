<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = "customers";

    public function fullName()
    {
        return $this->ad . ' ' . $this->ikinci_ad . ' ' . $this->soyad;
    }

    public function getApproves()
    {
        return $this->hasOne(CustomerApprove::class,'customer_id','id');
    }

    public function getAddressDelivery()
    {
        return $this->hasOne(CustomerAddress::class,'customer_id','id')->where('address_type',1);
    }
    public function getAddressInvoice()
    {
        return $this->hasOne(CustomerAddress::class,'customer_id','id')->where('address_type',2);
    }

    public function getFamily()
    {
        return $this->hasOne(CustomerFamily::class,'customer_id','id');
    }

    public function getCorporate()
    {
        return $this->hasOne(CustomerCorporate::class,'customer_id','id');
    }

    public function getInfo()
    {
        return $this->hasOne(CustomerInfo::class,'customer_id','id');
    }

    public function getEmergency()
    {
        return $this->hasOne(CustomerEmergency::class,'customer_id','id');
    }

    public function getOtherInfo()
    {
        return $this->hasOne(CustomerOtherInfo::class,'customer_id','id');
    }
    public function mobile_user(){
        return $this->hasOne(UserMobile::class,'id','mobile_user_id');
    }
    public function getMeasurement(){
        return $this->hasMany(Measurement::class,'customer_id','id');
    }

    public function getAdvisor()
    {
        return $this->hasOne(User::class,'id','danisman_id');
    }

    public function getBranch()
    {
        return $this->hasOne(Branches::class,'id','sube');
    }

    public function getTraining()
    {
        return $this->hasMany(TrainingFavorite::class,'customer_id','id');
    }

    public function getPackage()
    {
        return $this->hasOne(CustomerPackages::class,'customer_id','id');
    }
}
