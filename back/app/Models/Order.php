<?php

namespace App\Models;

use App\Traits\Blameable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    use Blameable;

    const PERCENTUAL_DISCOUNT = 15;

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'order_code',
        'order_date',
        'total_amount_wihtout_discount',
        'total_amount_with_discount'
    ];

    protected function order_date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::create($value)->format('d/m/Y')
        );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'orders_products', 'order_id', 'product_id')->withPivot(['user_id']);
    }
}
