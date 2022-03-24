<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_code',
        'order_date',
        'total_amount_wihtout_discount',
        'total_amount_with_discount',
        'finished',
        'products'
    ];

    protected $casts = ['products' => 'array'];

    protected function orderDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::create($value)->format('d/m/Y'),
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
