<?php

namespace App\Http\Controllers\Product;

use App\Product;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

class ProductController extends ApiController
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
        $products = Product::all();
        return $this->showAll($products);
    }

     public function ramdon()
    {
        $products = Product::inRandomOrder()->take(4)->get();
        return $this->showAll($products);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
         return $this->showOne($product);
    }

    public function show_best_seller(){
       $products = Product::bestSeller()->take(4)->get();
       $products = $products->map(function ($item, $key) {
            return Product::find($item->id);
        });
       return $this->showAll($products);
    }


    public function grupBycategories(){
        return Product::groupCategories()->get();
    }

}
