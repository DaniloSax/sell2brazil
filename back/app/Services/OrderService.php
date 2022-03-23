<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderService
{

    public static function applyDiscount(float $unitPrice, int $quantity): float
    {
        $totalPrice = $unitPrice * $quantity;
        $conditional = $quantity >= 5 && $quantity <= 9;

        $valueDiscount = ($totalPrice * Order::PERCENTUAL_DISCOUNT) / 100;

        if ($conditional && $totalPrice > 500) {

            return $totalPrice - $valueDiscount;
        }

        return 0;
    }
}
