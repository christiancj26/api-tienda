<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function login(Request $request)
    {
            $rules = [
                'username' => 'required|string',
                'password' => 'required|string'
            ];

            $this->validate($request, $rules);

            $user = User::whereEmail(request('username'))->first();

            if (! $user) {
                return response()->json([
                    'error' => ['username' => ['El usuario no existe en nuestros registros.']],
                    'code' => 422
                ], 422);
            }

            if (!Hash::check(request('password'), $user->password)) {
                return response()->json([
                    'error' => ['password' => ['La contraseña es incorrecta.']],
                    'code' => 422
                ], 422);
            }

			$response = Http::post('http://localhost:8001/oauth/token', [
                'grant_type' => 'password',
                'client_id' => config('services.passport.client_password_id'),
                'client_secret' => config('services.passport.client_password_secret'),
                'username' => $request->username,
                'password' => $request->password,
            ]);


            if ($response->clientError()) {
            	return response()->json(['error' => 'Tus credenciales son incorrectas o tu cuenta no ha sido verificada. Inténtalo de nuevo.', 'code' => 401], 401);
            }

			if ($response->serverError()) {
				return response()->json(['error' => 'Algo salió mal en el servidor.', 'code' => 500], 500);

			}

            return $response->json();
    }

     public function adminLogin(Request $request)
    {
            $rules = [
                'username' => 'required|string',
                'password' => 'required|string'
            ];

            $this->validate($request, $rules);

            $user = User::whereEmail(request('username'))->first();

            if (! $user) {
                return response()->json([
                    'error' => ['username' => ['El usuario no existe en nuestros registros.']],
                    'code' => 422
                ], 422);
            }

            if (!Hash::check(request('password'), $user->password)) {
                return response()->json([
                    'error' => ['password' => ['La contraseña es incorrecta.']],
                    'code' => 422
                ], 422);
            }

            if (! $user->admin) {
                return response()->json([
                    'error' => ['username' => ['No tienes autorización para ingresar.']],
                    'code' => 422
                ], 422);
            }

            $response = Http::post('http://localhost:8001/oauth/token', [
                'grant_type' => 'password',
                'client_id' => config('services.passport.client_password_id'),
                'client_secret' => config('services.passport.client_password_secret'),
                'username' => $request->username,
                'password' => $request->password,
            ]);


            if ($response->clientError()) {
                return response()->json(['error' => 'Tus credenciales son incorrectas o tu cuenta no ha sido verificada. Inténtalo de nuevo.', 'code' => 401], 401);
            }

            if ($response->serverError()) {
                return response()->json(['error' => 'Algo salió mal en el servidor.', 'code' => 500], 500);

            }

            return $response->json();
    }

    public function loginClient(Request $request)
    {

            $response = Http::post('http://localhost:8001/oauth/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('services.passport.client_credentials_id'),
                'client_secret' => config('services.passport.client_credentials_secret'),
            ]);


            if ($response->clientError()) {
                return response()->json(['error' => 'Tus credenciales son incorrectas. Inténtalo de nuevo.', 'code' => 401], 401);
            }

            if ($response->serverError()) {
                return response()->json(['error' => 'Algo salió mal en el servidor.', 'code' => 500], 500);

            }

            return $response->json();
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
