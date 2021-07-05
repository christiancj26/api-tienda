<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\TransactionTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
	use SoftDeletes;
    protected $fillable = [
        'quantity', 'sale_id', 'unit_price', 'product_id', 'subtotal'
    ];

    public $transformer = TransactionTransformer::class;

	protected $dates = ['deleted_at'];

    public function sale(){
    	return $this->belongsTo(Sale::class);
    }

    public function product(){
    	return $this->belongsTo(Product::class);
    }

}
