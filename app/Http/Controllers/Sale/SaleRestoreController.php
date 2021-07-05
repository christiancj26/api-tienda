<?php

namespace App\Http\Controllers\Sale;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Sale;
use App\Product;

class SaleRestoreController extends ApiController
{
    public function restore($id){
        $sale = Sale::find($id);

        if ($sale->transactions) {
            $transactions = $sale->transactions;
            foreach ($transactions as $key => $transaction) {
                $product = Product::find($transaction->product_id);
                $product->quantity += $transaction->quantity;
                $product->save();
            }

            $sale->transactions->each(function ($transaction) {
               $transaction->forcedelete();
            });
        }

        if ($sale->invoice) {
            $sale->invoice->forceDelete();
        }

        $sale->forceDelete();

        return $this->showOne($sale);
    }
}
