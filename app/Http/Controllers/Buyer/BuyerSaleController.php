<?php

namespace App\Http\Controllers\Buyer;

use App\Sale;
use App\User;
use App\Buyer;
use App\Product;
use App\Invoice;
use App\Transaction;
use Illuminate\Http\Request;
use App\Notifications\OrderPlaced;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Transformers\SaleTransformer;
use App\Http\Controllers\ApiController;

class BuyerSaleController extends ApiController
{

    public function __construct()
    {
        parent::__construct();

        $this->middleware('transform.input:' . SaleTransformer::class)->only(['store']);
        /*$this->middleware('scope:purchase-product')->only('store');
        $this->middleware('can:purchase,buyer')->only('store');*/
    }

    public function index(Buyer $buyer){
        $sales = $buyer->sales;

        return $this->showAll($sales);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $buyer)
    {

        $validator = Validator::make($request->all(), [
            'buyer_id' => 'required|integer',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'discount' => 'required|numeric',
            'shipping_costs' => 'required|numeric',
            'observation' => 'nullable|string',
            'status' => 'required|string',
            'transactions.*.product_id' => 'required|integer|min:1',
            'transactions.*.quantity' => 'required|integer|min:1',
            'transactions.*.unit_price' => 'required|numeric'
        ])->validate();

        if (!$buyer->isVerified()) {
            return $this->errorResponse('Para poder comprar debes tener una cuenta Verificada', 409);
        }

        return DB::transaction(function () use ($request, $buyer) {
            $sale = Sale::create($request->all());
            if ($sale and $sale->voucher == 'si') {
                $invoice_number = DB::table('invoices')->max('invoice_number') + 1;
                Invoice::create([
                    'invoice_number' =>  $invoice_number,
                    'iva' => $sale->total * .16,
                    'sale_id' => $sale->id,
                    'buyer_id' => $buyer->id,
                ]);
            }
            foreach ($request->transactions as $key => $transaction) {
                $product =  Product::find($transaction['product_id']);
                if ($buyer->id == $product->seller_id) {
                    $this->restore($sale->id);
                    return $this->errorResponse('El comprador debe ser diferente al vendedor', 409);
                }
                if (!$product->isAvailable()) {
                    $this->restore($sale->id);
                    return $this->errorResponse('El producto '.$product->full_name.'  no está disponible para esta compra.', 409);
                }
                if ($product->quantity < $transaction['quantity']) {
                    $this->restore($sale->id);
                    return $this->errorResponse('El producto '.$product->full_name.' no tiene la cantidad disponible requerida para esta compra', 402);
                }
                DB::transaction(function () use ($transaction, $product, $sale) {
                    $product->quantity -= $transaction['quantity'];
                    $product->save();
                    $transaction = Transaction::create([
                        'quantity' => $transaction['quantity'],
                        'sale_id' => $sale->id,
                        'product_id' => $product->id,
                        'subtotal' => $transaction['quantity'] * ($product->discount != 0 ? $product->discount : $product->price),
                        'unit_price' => $product->discount != 0 ? $product->discount : $product->price,
                    ]);
                });
            }
            return $this->showOne($sale, 201);
        });
    }

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
