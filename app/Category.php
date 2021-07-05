<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'slug', 'description'
    ];

    public $transformer = CategoryTransformer::class;

    protected $hidden = [
        'pivot'
    ];

    public static function create(array $attributes = []){
        $category = static::query()->create($attributes);
        $category->generateUrl();
        return $category;
    }

    public function generateUrl(){
        $slug = Str::slug($this->name, '-');
        if ($this->whereSlug($slug)->exists()) {
            $slug = "{$slug}-{$this->id}";
        }
        $this->slug =  $slug;
        $this->save();
    }

    public function products(){
    	return $this->belongsToMany(Product::class);
    }

     public function scopeGroupProducts($query){
            return $query->select([
                'categories.name',
                DB::raw('COUNT(products.id) as total_ventas')
            ]);
    }
}
