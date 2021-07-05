<?php

namespace App;

use App\Transaction;
use App\Scopes\BuyerScope;
use App\Transformers\BuyerTransformer;

class Buyer extends User
{
	protected static function boot()
	{
		parent::boot();

		static::addGlobalScope(new BuyerScope);
	}

	public $transformer = BuyerTransformer::class;

	protected $appends = [
        'full_name', 'full_address'
    ];

    public function getFullNameAttribute(){
        return "{$this->name} {$this->profile->surnames}";
    }

    public function getFullAddressAttribute(){
        return "{$this->profile->address}, {$this->profile->city} {$this->profile->state}, {$this->profile->country}";
    }

    public function sales(){
    	return $this->hasMAny(Sale::class);
    }
/*
    public function transactions(){
    	return $this->hasMAny(Transaction::class);
    }*/
}
