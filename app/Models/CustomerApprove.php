<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerApprove extends Model
{
    use HasFactory;

    protected $hidden = [
        'customer_id',
        'created_at',
        'updated_at',
    ];
}
