<?php

namespace App\Http\Controllers\Size;

use App\Size;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class SizeController extends ApiController
{
     public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::all();
        return $this->showAll($sizes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        return $this->showOne($size);
    }
}
