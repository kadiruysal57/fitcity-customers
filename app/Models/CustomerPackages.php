<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPackages extends Model
{
    use HasFactory,SoftDeletes;

    public function package(){
        return $this->hasOne(Packages::class,'id','packages_id');
    }
    public function package_repeat(){
        return $this->hasOne(CustomerPackageRepeat::class,'customer_packages_id','id');
    }
    public function branch(){
        return $this->hasOne(Branches::class,'id','branch_id');
    }

    public function getDanisman()
    {
        return $this->hasOne(User::class,'id','satis_temsilcisi');
    }
}
