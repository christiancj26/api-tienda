<?php

namespace App;

use App\Transformers\TypeTransformer;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
	protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description'
    ];

    public $transformer = TypeTransformer::class;

    public function products(){
    	return $this->hasMany(Product::class);
    }
}
