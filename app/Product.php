<?php

namespace App;

use App\Seller;
use App\Category;
use App\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
	const PRODUCT_AVIALABLE = 'available';
	const PRODUCT_NOT_AVIALABLE = 'not available';

    protected $fillable = [
        'name', 'description', 'type_id', 'size_id', 'brand_id', 'quantity', 'price', 'discount', 'status', 'image', 'seller_id'
    ];

    protected $dates = ['deleted_at'];

    public $transformer = ProductTransformer::class;

    protected $hidden = [
        'pivot'
    ];

    protected $appends = [
        'full_name'
    ];

    public function getFullNameAttribute(){
        if ($this->type AND $this->size) {
            return "{$this->name} {$this->type->name} {$this->size->name}";
        }elseif($this->type){
            return "{$this->name} {$this->type->name}";
        }elseif($this->size){
            return "{$this->name} {$this->size->name}";
        }else{
            return "{$this->name}";
        }

    }

    public function isAvailable(){
    	return $this->status == Product::PRODUCT_AVIALABLE;
    }

    public function isNotAvailable(){
        return $this->status == Product::PRODUCT_NOT_AVIALABLE;
    }

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }

    public function seller(){
    	return $this->belongsTo(Seller::class);
    }

    public function transactions(){
    	return $this->hasMany(Transaction::class);
    }

    public function categories(){
    	return $this->belongsToMany(Category::class);
    }

    public function scopeBestSeller($query){
            return $query->select([
                'products.id',
                DB::raw('SUM(transactions.quantity) as total_ventas'),
            ])
            ->join('transactions', 'transactions.product_id', '=', 'products.id')
            ->join('sales', 'transactions.sale_id', '=', 'sales.id')
            ->where('sales.status','realizado')
            ->groupBy('products.id')
            ->orderByDesc('total_ventas');
    }

}
