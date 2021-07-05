<?php

namespace App\Http\Controllers\Type;

use App\Type;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class TypeController extends ApiController
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
        $types = Type::all();
        return $this->showAll($types);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return $this->showOne($type);
    }
}
