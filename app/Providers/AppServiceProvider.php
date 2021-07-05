<?php

namespace App\Providers;

use App\Sale;
use App\User;
use App\Product;
use App\Mail\UserCreated;
use App\Mail\UserMailChanged;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        User::created(function($user) {
            retry(5, function() use ($user) {
                Mail::to($user)->send(new UserCreated($user));
            }, 100);
        });

        User::updated(function($user) {
            if ($user->isDirty('email')) {
                retry(5, function() use ($user) {
                    Mail::to($user)->send(new UserMailChanged($user));
                }, 100);
            }
        });

        Sale::created(function($sale) {
            $sale->number_order = substr(str_shuffle("0123456789"), 0, 7);
            $sale->save();
        });

        Product::updated(function($product) {
            if ($product->quantity == 0 && $product->isAvailable()) {
                $product->status = Product::PRODUCT_NOT_AVIALABLE;
                $product->save();
            }
            if ($product->quantity >= 1 && $product->isNotAvailable()){
                $product->status = Product::PRODUCT_AVIALABLE;
                $product->save();
            }
        });

        Blade::directive('precio', function ($price) {
            setlocale(LC_MONETARY,"es_ES");
            return "<?php echo money_format('%.2n', $price); ?>";
        });
    }
}
