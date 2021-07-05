<?php

namespace App;

use App\Transformers\BrandTransformer;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description'
    ];

    public $transformer = BrandTransformer::class;

    public function products(){
    	return $this->hasMany(Product::class);
    }
}
