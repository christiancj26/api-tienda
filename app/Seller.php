<?php

namespace App;

use App\Product;
use App\Scopes\SellerScope;
use App\Transformers\SellerTransformer;

class Seller extends User
{
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new SellerScope);
	}

	public $transformer = SellerTransformer::class;

    public function products(){
    	return $this->hasMAny(Product::class);
    }
}
