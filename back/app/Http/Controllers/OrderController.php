<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

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


    public function store(Request $request)
    {
        $order = Order::firstOrCreate(['finished' => false], ['order_date' => date('Y-m-d')]);

        $order->products()->attach($request->id, ['user_id' => Auth::id()]);

        $quatity = $order->products()->count();
        $total_amount_wihtout_discount = $order->products->reduce(fn ($acum, $item) => $acum += $item->unit_price);

        $order->total_amount_wihtout_discount = $total_amount_wihtout_discount;

        $order->total_amount_with_discount = OrderService::applyDiscount(
            $total_amount_wihtout_discount,
            $quatity
        );

        $order->save();

        return response()->json($order, Response::HTTP_OK);
    }


    public function show(Order $order)
    {
        //
    }


    public function update(Request $request, Order $order)
    {
        $order->finished = true;
        $order->save();

        Purchase::create([
            'user_id' => Auth::id(),
            'order_code' => $order->order_code,
            'order_date' => $order->order_date,
            'total_amount_wihtout_discount' => $order->total_amount_wihtout_discount,
            'total_amount_with_discount' => $order->total_amount_with_discount,
            'finished' => $order->finished,
            'products' => ProductResource::collection($order->products->unique('article_code'))
        ]);

        $order->delete();

        return response()->json(['order' => $order], Response::HTTP_OK);
    }

    public function detacheProduct(Product $product)
    {

        $id = DB::table('orders_products')->where('product_id', $product->id)->first()->id;

        DB::table('orders_products')->where('id', $id)->delete();

        return response(null, Response::HTTP_OK);
    }


    public function destroy(Order $order)
    {
        $order->delete();

        return response(null, Response::HTTP_OK);
    }
}
