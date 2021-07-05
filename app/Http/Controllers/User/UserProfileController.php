<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Transformers\ProfileTransformer;

class UserProfileController extends ApiController
{
    public function __construct()
    {
        $this->middleware('transform.input:' . ProfileTransformer::class)->only(['store']);
        $this->middleware('client.credentials')->only(['store']);
        $this->middleware('auth:api')->except(['store']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {   $profile = $user->profile;
        return $this->showOne($profile);
    }

    public function store(Request $request, User $user){

        $reglas = [
            'surnames' => 'required|min:3',
            'address' => 'required|min:3',
            'phone' => 'required|min:6',
            'postal_code' => 'required|min:3',
            'city' => 'required|min:3',
            'state' => 'required|min:3',
            'country' => 'required|min:3',
            'rfc' => 'required|min:3',
        ];

        $datos =  $this->validate($request, $reglas);

        $profile = $user->profile()->create($datos);

        return $this->showOne($profile);
    }

}
