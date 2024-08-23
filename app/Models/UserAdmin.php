<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    use HasFactory;
    protected $table = "users_admin";
    protected $hidden = [
        'password',
        'permission_role',
        'add_user',
        'update_user',

        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];
    public function informations(){
        return $this->hasOne(PersonelInformation::class,'personel_id','id');
    }
    public function permission(){
        return $this->hasOne(permission::class,'id','permission_role');
    }
    public function private_lesson(){
        return $this->hasOne(PrivateLesson::class,'personel_id','id');
    }
    public function getAverageRating(){
        $average = LessonPoints::where('personel_id', $this->id)->avg('general_rate');
        return round($average) ?? 0;
    }
}
