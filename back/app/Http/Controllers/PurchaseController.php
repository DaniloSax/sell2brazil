<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{

    public function index()
    {
       return response()->json(['purchases' => Auth::user()->purchases]);
    }


    public function store(Request $request)
    {
        //
    }


    public function show(Purchase $purchase)
    {
        //
    }


    public function update(Request $request, Purchase $purchase)
    {
        //
    }


    public function destroy(Purchase $purchase)
    {
        //
    }
}
