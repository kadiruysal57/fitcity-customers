<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Packages extends Model
{
    use HasFactory,SoftDeletes;


    public function detils()
    {
        return $this->hasMany(PackageDetails::class,'package_id','id')->orderBy('detail_order','asc');
    }
}
