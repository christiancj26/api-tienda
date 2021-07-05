<?php

namespace App\Transformers;

use App\Product;
use League\Fractal\TransformerAbstract;
use App\Transformers\CategoryTransformer;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'categorias'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identificador' => (int)$product->id,
            'titulo' => (string)$product->name,
            'titulo_completo' => (string)$product->full_name,
            'detalles' => (string)$product->description,
            'tipo' => $product->type,
            'tipo_id' => (int)$product->type_id,
            'tamano' => $product->size,
            'tamano_id' => $product->size_id,
            'marca_id' => $product->brand_id,
            'marca' => $product->brand,
            'disponibles' => (int)$product->quantity,
            'precio' => (double)$product->price,
            'precio_oferta' => (double)$product->discount,
            'estado' => (string)$product->status,
            'foto' => url('img/'.$product->image),
            'vendedor' => (int)$product->seller_id,
            'fechaCreacion' => (string)$product->created_at,
            'fechaActualizacion' => (string)$product->updated_at,
            'fechaEliminacion' => isset($product->deleted_at) ? (string) $product->deleted_at : null,

            'links' => [
                [
                    'rel' => 'self',
                    'href' => route('products.show', $product->id),
                ],
                [
                    'rel' => 'product.buyers',
                    'href' => route('products.buyers.index', $product->id),
                ],
                [
                    'rel' => 'product.categories',
                    'href' => route('products.categories.index', $product->id),
                ],
                [
                    'rel' => 'product.transactions',
                    'href' => route('products.transactions.index', $product->id),
                ],
                [
                    'rel' => 'seller',
                    'href' => route('sellers.show', $product->seller_id),
                ],
            ],
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'titulo' => 'name',
            'detalles' => 'description',
            'categoria' => 'category',
            'tipo_id' => 'type_id',
            'tamano_id' => 'size_id',
            'marca_id' => 'brand_id',
            'disponibles' => 'quantity',
            'precio' => 'price',
            'precio_oferta' => 'discount',
            'estado' => 'status',
            'foto' => 'image',
            'vendedor' => 'seller_id',
            'fechaCreacion' => 'created_at',
            'fechaActualizacion' => 'updated_at',
            'fechaEliminacion' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformedAttribute($index)
    {
        $attributes = [
            'id' => 'identificador',
            'name' => 'titulo',
            'description' => 'detalles',
            'category' => 'categoria',
            'type_id' => 'tipo_id',
            'size_id' => 'tamano_id',
            'brand_id' => 'marca_id',
            'quantity' => 'disponibles',
            'price' => 'precio',
            'discount' => 'precio_oferta',
            'status' => 'estado',
            'image' => 'foto',
            'seller_id' => 'vendedor',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public function includeCategorias(Product $product) {
        $categorias = $product->categories;
        return $this->collection($categorias, new CategoryTransformer);
    }

}
