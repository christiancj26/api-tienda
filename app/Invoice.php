<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;

     protected $fillable = [
        'invoice_number', 'Method_of_payment', 'iva', 'sale_id', 'buyer_id', 'created_at', 'update_at'
    ];

     protected $dates = ['deleted_at'];

     /*public $transformer = ProductTransformer::class;*/

     public function buyer(){
    	return $this->belongsTo(Buyer::class);
    }

    public function sale(){
    	return $this->belongsTo(Sale::class);
    }
}
