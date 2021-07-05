<?php

namespace App\Http\Controllers\Sale;

use App\Sale;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class SaleReceiptController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['getLinkPdf']);
        /*$this->middleware('can:view,sale')->only('index');*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($sale)
    {
        $sale = Sale::where('number_order', $sale)->firstOrFail();
        $sale = Sale::with('transactions.product', 'buyer')->find($sale->id);
        $pdf = PDF::loadView('receipt.receipt', compact('sale'));
        if (request()->wantsJson()) {
            $pdf->setPaper('A4' , 'portrait');
            return $pdf->output();
        }

        return $pdf->download('recibo_'.$sale->number_order.'.pdf');

    }

    public function getLinkPdf($sale){
        return route('sales.receipts.index', $sale);
    }

    public function show($id){

    }
}
