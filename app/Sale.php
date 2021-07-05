<?php

namespace App;

use App\Transformers\SaleTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'buyer_id', 'number_order', 'voucher', 'tax', 'subtotal', 'discount', 'shipping_costs', 'total', 'status', 'observation'
    ];

    public $transformer = SaleTransformer::class;

    protected $dates = ['deleted_at'];

    protected $appends = [
        'url_pdf'
    ];

    public function getUrlPdfAttribute(){
        return route('sales.receipts.index', $this->number_order);
    }

    public function buyer(){
        return $this->belongsTo(User::class);
    }

    public function invoice(){
        return $this->hasOne(Invoice::class);
    }

    public function transactions(){
    	return $this->hasMany(Transaction::class);
    }
}
