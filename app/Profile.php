<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Transformers\ProfileTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
	use SoftDeletes;

     protected $fillable = [
       'user_id', 'surnames', 'address', 'phone', 'postal_code', 'city', 'state', 'country', 'rfc'
    ];

     public $transformer = ProfileTransformer::class;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
