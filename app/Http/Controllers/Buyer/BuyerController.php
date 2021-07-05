<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use Illuminate\Http\Request;
use App\Transformers\BuyerTransformer;
use App\Http\Controllers\ApiController;

class BuyerController extends ApiController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('transform.input:' . BuyerTransformer::class)->only(['update']);
        /*$this->middleware('scope:read-general')->only('show');
        $this->middleware('can:view,buyer')->only('show');*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $buyers = Buyer::all();
         return $this->showAll($buyers);
    }

    public function update(Request $request, Buyer $buyer){
         $reglas = [
            'discount' => 'required|numeric',
        ];

        $this->validate($request, $reglas);

        $buyer->fill($request->only([
            'discount',
        ]));

        $buyer->save();

        return $this->showOne($buyer);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer);
    }

}
