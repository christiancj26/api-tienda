<?php

namespace App\Http\Controllers\Product;

use App\Sale;
use App\Product;
use App\Transaction;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Transformers\TransactionTransformer;

class ProductSaleTransactionController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . TransactionTransformer::class)->only(['store']);
        /*$this->middleware('scope:purchase-product')->only('store');
        $this->middleware('can:purchase,buyer')->only('store');*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, Sale $sale)
    {

        $rules = [
            'product_id' => 'required|integer|min:1',
            'sale_id' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'subtotal' => 'required|numeric',
            'unit_price' => 'required|numeric'
        ];

        $this->validate($request, $rules);


        if ($sale->buyer->id == $product->seller_id) {
            return $this->errorResponse('El comprador debe ser diferente al vendedor', 409);
        }

        if (!$sale->buyer->isVerified()) {
            return $this->errorResponse('El comprador debe ser un usuario verificado', 409);
        }

        /*if (!$product->seller->isVerified()) {
            return $this->errorResponse('El vendedor debe ser un usuario verificado', 409);
        }*/

        if (!$product->isAvailable()) {
            return $this->errorResponse('El producto '.$product->full_name.'  no está disponible para esta compra.', 409);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('El producto '.$product->name.' '.$product->type->name.' '.$product->size->name.' no tiene la cantidad disponible requerida para esta compra', 402);
        }

        return DB::transaction(function () use ($request, $product, $sale) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'sale_id' => $sale->id,
                'product_id' => $product->id,
                'subtotal' => $request->quantity * ($product->discount != 0 ? $product->discount : $product->price),
                'unit_price' => $product->discount != 0 ? $product->discount : $product->price,
            ]);

            return $this->showOne($transaction, 201);
        });
    }
}
