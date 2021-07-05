<?php

namespace App\Http\Controllers\Profile;

use App\Profile;
use App\Http\Controllers\ApiController;
use App\Transformers\ProfileTransformer;
use Illuminate\Http\Request;

class ProfileController extends ApiController
{
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['store']);
        $this->middleware('auth:api')->except(['store']);
        $this->middleware('transform.input:' . ProfileTransformer::class)->only(['store', 'update']);
       /* $this->middleware('scope:manage-account')->only(['show', 'update']);*/
        $this->middleware('can:view,profile')->only('show');
        $this->middleware('can:update,profile')->only('update');
        $this->middleware('can:delete,profile')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile)
    {
         $reglas = [
            'surnames' => 'required|min:3',
            'address' => 'required|min:3',
            'phone' => 'required|min:3',
            'postal_code' => 'required|min:3',
            'city' => 'required|min:3',
            'state' => 'required|min:3',
            'country' => 'required|min:3',
            'rfc' => 'required|min:3',
        ];

        $this->validate($request, $reglas);

        $profile->fill($request->only([
            'surnames',
            'address',
            'phone',
            'postal_code',
            'city',
            'state',
            'country',
            'rfc',
        ]));

        if (!$profile->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar', 409);
        }

        $profile->save();

        return $this->showOne($profile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
