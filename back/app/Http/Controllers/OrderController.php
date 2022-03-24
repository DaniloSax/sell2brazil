<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            })
                ->orderBy('finished')
                ->latest()
                ->get();

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
        $quatity = (float) $request->quantity;
        $unitPrice = (float) $request->unitPrice;

        $order = Order::firstOrCreate(
            [
                'finished' => false
            ],
            [
                'order_date' => date('Y-m-d'),
                'total_amount_wihtout_discount' => $unitPrice * $quatity,
                'total_amount_with_discount' => OrderService::applyDiscount($unitPrice, $quatity),
            ]
        );

        $order->products()->attach($request->id, ['user_id' => Auth::id()]);

        return response()->json($order, Response::HTTP_OK);
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
        $order->finished = true;
        $order->save();

        return response()->json(['order' => $order], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response(null, Response::HTTP_OK);
    }
}
