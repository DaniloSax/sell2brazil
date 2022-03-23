<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $orders = Order::whereHas('products', function ($query) {
                $query->where('user_id', Auth::id());
            })->get();

            return response()->json(['orders' => OrderResource::collection($orders)], Response::HTTP_OK);
        }

        return response(null, Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $order = Order::create([
            'order_date' => date('Y-m-d'),
            'total_amount_wihtout_discount' => $request->unitPrice * $request->quantity,
            'total_amount_with_discount' => $this->applyDiscount($request->unitPrice, $request->quantity)
        ]);

        $products = Product::where('article_code', $request->articleCode)->limit($request->quantity)->get();

        $order->products()->attach($products->pluck('id'), ['user_id' => Auth::id()]);

        return response()->json($order, Response::HTTP_OK);
    }

    private function applyDiscount(float $unitPrice, int $quantity): float
    {
        $totalPrice = $unitPrice * $quantity;
        $conditional = $quantity >= 5 && $quantity <= 9;

        $valueDiscount = ($totalPrice * Order::PERCENTUAL_DISCOUNT) / 100;

        if ($conditional && $totalPrice > 500) {

            return $totalPrice - $valueDiscount;
        }

        return 0;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
