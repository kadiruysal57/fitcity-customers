<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPackageRepeat extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "customer_package_repeat";
}
