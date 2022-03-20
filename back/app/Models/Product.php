<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Traits\Blameable;
use Keygen\Keygen;

class Product extends Model
{
    use HasFactory, Blameable;

    const PRODUCTS_FACTORY =  [
        ['name' => 'Teclado', 'price' => 200, 'article_code'=> 526879],
        ['name' => 'Mouse', 'price' => 3000, 'article_code'=> 789456],
        ['name' => 'Mesa', 'price' => 1250, 'article_code'=> 456123],
        ['name' => 'Cadeira', 'price' => 3080, 'article_code'=> 789354],
    ];

    protected $fillable = [
        'user_id',
        'article_code',
        'article_name',
        'unit_price',
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }


    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders_products', 'product_id', 'order_id')->withPivot(['user_id']);
    }

    // private function generateoArticleCode()
    // {
    //     return $code = Keygen::numeric(6)->prefix(mt_rand(1, 9))->generate(true);
    // }
}
