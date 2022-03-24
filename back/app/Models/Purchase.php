<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'order_date',
        'total_amount_wihtout_discount',
        'total_amount_with_discount',
        'finished',
        'products'
    ];
}
