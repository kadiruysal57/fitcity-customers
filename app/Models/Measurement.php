<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Measurement extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "measurements";


    public function getPersonel()
    {
        return $this->hasOne(UserAdmin::class,'id','personel_id');
    }
}
