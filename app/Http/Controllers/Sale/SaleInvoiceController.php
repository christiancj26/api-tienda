<?php

namespace App\Http\Controllers\Sale;

use App\Sale;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleInvoiceController extends Controller
{

    public function index(Sale $sale)
    {
        $datos = $sale->invoice()->with('sale.transactions','buyer.profile')->get();
        $pdf = PDF::loadView('welcome', compact('datos',$datos));
        return $pdf->stream('invoice.pdf');
    }

}
