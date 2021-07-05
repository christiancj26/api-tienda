<?php

namespace App\Transformers;

use App\Profile;
use League\Fractal\TransformerAbstract;

class ProfileTransformer extends TransformerAbstract
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
    public function transform(Profile $profile)
    {
        return [
            'identificador' => (int)$profile->id,
            'apellidos' => (string)$profile->surnames,
            'direccion' => (string)$profile->address,
            'telefono' => (string)$profile->phone,
            'codigo_postal' => (string)$profile->postal_code,
            'ciudad' => (string)$profile->city,
            'estado' => (string)$profile->state,
            'pais' => (string)$profile->country,
            'identificacion' => (string)$profile->rfc,
            'fechaCreacion' => (string)$profile->created_at,
            'fechaActualizacion' => (string)$profile->updated_at,
            'fechaEliminacion' => isset($user->deleted_at) ? (string) $user->deleted_at : null,
        ];
    }

     public static function originalAttribute($index)
    {
        $attributes = [
            'identificador' => 'id',
            'apellidos' => 'surnames',
            'direccion' => 'address',
            'telefono' => 'phone',
            'codigo_postal' => 'postal_code',
            'ciudad' => 'city',
            'estado' => 'state',
            'pais' => 'country',
            'identificacion' => 'rfc',
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
            'surnames' => 'apellidos',
            'address' => 'direccion',
            'phone' => 'telefono',
            'postal_code' => 'codigo_postal',
            'city' => 'ciudad',
            'state' => 'estado',
            'country' => 'pais',
            'rfc' => 'identificacion',
            'created_at' => 'fechaCreacion',
            'updated_at' => 'fechaActualizacion',
            'deleted_at' => 'fechaEliminacion',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
