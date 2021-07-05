<?php

namespace App\Transformers;

use App\Brand;
use League\Fractal\TransformerAbstract;

class BrandTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
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
    public function transform(Brand $brand)
    {
        return [
            'identificador' => (int)$brand->id,
            'titulo' => (string)$brand->name,
            'detalles' => (string)$brand->description,
            'fechaCreacion' => (string)$brand->created_at,
            'fechaActualizacion' => (string)$brand->updated_at,
            'fechaEliminacion' => isset($brand->deleted_at) ? (string) $type->deleted_at : null,
        ];
    }
}
