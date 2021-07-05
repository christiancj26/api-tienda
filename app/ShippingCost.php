<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShippingCost extends Model
{
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'price', 'description'
    ];
}
