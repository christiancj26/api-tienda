<?php

namespace App\Transformers;

use App\Type;
use League\Fractal\TransformerAbstract;

class TypeTransformer extends TransformerAbstract
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
    public function transform(Type $type)
    {
        return [
            'identificador' => (int)$type->id,
            'titulo' => (string)$type->name,
            'detalles' => (string)$type->description,
            'fechaCreacion' => (string)$type->created_at,
            'fechaActualizacion' => (string)$type->updated_at,
            'fechaEliminacion' => isset($type->deleted_at) ? (string) $type->deleted_at : null,
        ];
    }
}
