<?php

namespace App\Transformers;

use App\Size;
use League\Fractal\TransformerAbstract;

class SizeTransformer extends TransformerAbstract
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
    public function transform(Size $size)
    {
        return [
            'identificador' => (int)$size->id,
            'titulo' => (string)$size->name,
            'detalles' => (string)$size->description,
            'fechaCreacion' => (string)$size->created_at,
            'fechaActualizacion' => (string)$size->updated_at,
            'fechaEliminacion' => isset($size->deleted_at) ? (string) $type->deleted_at : null,
        ];
    }
}
