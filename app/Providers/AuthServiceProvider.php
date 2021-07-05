<?php

namespace App\Providers;

use App\User;
use App\Profile;
use App\Sale;
use Carbon\Carbon;
use App\Transaction;
use App\Policies\UserPolicy;
use App\Policies\ProfilePolicy;
use App\Policies\SalePolicy;
use Laravel\Passport\Passport;
use App\Policies\TransactionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         Transaction::class => TransactionPolicy::class,
         Sale::class => SalePolicy::class,
         Profile::class => ProfilePolicy::class,
         User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin-action', function ($user) {
            return $user->esAdministrador();
        });

        Passport::routes();
        /*Passport::tokensExpireIn(Carbon::now()->addDays(1));*/
        Passport::tokensExpireIn(Carbon::now()->addMonths(6));
        Passport::refreshTokensExpireIn(Carbon::now()->addDays(30));
        Passport::personalAccessTokensExpireIn(now()->addMonths(6));
        Passport::enableImplicitGrant();

        Passport::tokensCan([
            'purchase-product' => 'Crear transacciones para comprar productos determinados',
            'manage-products' => 'Crear, ver, actualizar y eliminar productos',
            'manage-account' => 'Obtener la informacion de la cuenta, nombre, email, estado (sin contraseña), modificar datos como email, nombre y contraseña. No puede eliminar la cuenta',
            'read-general' => 'Obtener información general, categorías donde se compra y se vende, productos vendidos o comprados, transacciones, compras y ventas',
        ]);
    }
}
