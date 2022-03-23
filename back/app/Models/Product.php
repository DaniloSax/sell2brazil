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
        ['name' => 'Teclado', 'price' => 200, 'article_code' => 526879, 'article_description' => "Teclado Mecânico Gamer T-Dagger Bora, RGB, Switch Outemu Brown, PT - T-TGK315-BROWN", 'image' => "https://images.kabum.com.br/produtos/fotos/150980/teclado-mecanico-gamer-hyperx-alloy-origins-60-rgb-usb-hyperx-red-switch-design-compacto-anti-ghosting-abnt2-preto-hkbo1s-rb-usg_1616771985_g.jpg"],
        ['name' => 'Mouse', 'price' => 3000, 'article_code' => 789456, 'article_description' => "Mouse Gamer Redragon Cobra, Chroma RGB, 12400DPI, 7 Botões, Preto - M711 V2", 'image' => "https://m.media-amazon.com/images/I/61mpMH5TzkL._AC_SY450_.jpg"],
        ['name' => 'Mesa', 'price' => 1250, 'article_code' => 456123, 'article_description' =>  "Mesa Office Hayonik MHO 1100, Amêndola Rústica, Estilo Industrial, Pés Niveladores e Suporta Peso Máximo de 150 Kg - 72311", 'image' => "https://m.media-amazon.com/images/I/517AE7sGOpL._AC_SX450_.jpg"],
        ['name' => 'Cadeira', 'price' => 3080, 'article_code' => 789354, 'article_description' => "Cadeira Gamer ThunderX3 TGC12, Black", 'image' => "https://a-static.mlcdn.com.br/1500x1500/cadeira-gamer-fox-racer-rgb-preta-com-iluminacao-led/foxonline/33/e73793d24d8bafd852e052f9b7dab0ea.jpg"],
        ['name' => 'Computador', 'price' => 8020, 'article_code' => 85645, 'article_description' => "Computador Gamer BRX Powered By Asus, Intel Core i5-9400F, 16GB, SSD 240GB, Asus NVIDIA GeForce GTX 1650 4GB, Windows 10 Pro - PCI59400F16GB", 'image' => "https://m.media-amazon.com/images/I/61RxvVVF2JL._AC_SX450_.jpg"]
    ];

    protected $fillable = [
        'user_id',
        'article_code',
        'article_name',
        'article_description',
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
}
