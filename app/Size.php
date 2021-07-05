<?php

namespace App;

use App\Transformers\SizeTransformer;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description'
    ];

    public $transformer = SizeTransformer::class;

    public function products(){
    	return $this->hasMany(Product::class);
    }
}
