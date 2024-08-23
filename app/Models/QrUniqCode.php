<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QrUniqCode extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "qr_uniq_code";
}
