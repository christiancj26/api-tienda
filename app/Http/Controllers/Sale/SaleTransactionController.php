<?php

namespace App\Http\Controllers\Sale;

use App\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SaleTransactionController extends ApiController
{
     public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
        /*$this->middleware('can:view,sale')->only('index');*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Sale $sale)
    {
        $sale = $sale->transactions()->with('product.type')->with('product.size')->get();
        return $this->showAll($sale);
    }
}
