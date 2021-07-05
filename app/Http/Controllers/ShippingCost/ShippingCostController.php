<?php

namespace App\Http\Controllers\ShippingCost;

use App\ShippingCost;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShippingCostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ShippingCost::select('id','name', 'price', 'description')->get();
    }
}
