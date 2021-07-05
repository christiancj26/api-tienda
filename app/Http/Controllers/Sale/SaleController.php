<?php

namespace App\Http\Controllers\Sale;

use App\Sale;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Transformers\SaleTransformer;
use App\Http\Controllers\ApiController;
use App\Notifications\ChangeSaleStatus;

class SaleController extends ApiController
{
     public function __construct()
    {
         parent::__construct();
        $this->middleware('auth:api')->except(['index', 'show', 'byStatus']);
        $this->middleware('transform.input:' . SaleTransformer::class)->only(['update']);
        $this->middleware('can:view,sale')->only('show');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sale = Sale::all();
        return $this->showAll($sale);
    }

    public function byStatus(){
        return DB::table('sales')
                 ->select('status', DB::raw('count(*) as total'))
                 ->groupBy('status')
                 ->get();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
         return $this->showOne($sale);
    }

    public function update(Request $request, Sale $sale){
        $reglas = [
            'status' => ['required', Rule::in(['pendiente', 'realizado', 'cancelado'])],
        ];

        $this->validate($request, $reglas);

        $sale->fill($request->only([
            'status',
        ]));

        $sale->save();

        $sale->buyer->notify(new ChangeSaleStatus($sale));

        return $this->showOne($sale);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        return $sale->transactions;
    }

    public function failedrestore(Sale $sale){
        return $sale;
    }
}
