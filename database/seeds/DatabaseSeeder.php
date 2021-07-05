<?php

use App\Size;
use App\Type;
use App\User;
use App\Brand;
use App\Product;
use App\Profile;
use App\Category;
use App\Transaction;
use App\ShippingCost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');

    	User::truncate();
    	Category::truncate();
        Product::truncate();
    	Profile::truncate();
        Transaction::truncate();
        Type::truncate();
    	Size::truncate();
        Brand::truncate();
        ShippingCost::truncate();
    	DB::table('category_product')->truncate();

    	DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        User::flushEventListeners();
        Category::flushEventListeners();
        Profile::flushEventListeners();
        Product::flushEventListeners();
        Transaction::flushEventListeners();
        Type::flushEventListeners();
        Size::flushEventListeners();
        Brand::flushEventListeners();
        ShippingCost::flushEventListeners();

        $shipping_costs = new ShippingCost();
        $shipping_costs->name = "Zona metropolitana de Guadalajara";
        $shipping_costs->price = 70.00;
        $shipping_costs->description = "de uno a dos días habiles";
        $shipping_costs->save();

        $shipping_costs = new ShippingCost();
        $shipping_costs->name = "Cualquier parte de la República";
        $shipping_costs->price = 170.00;
        $shipping_costs->description = "de tres a cinco días habiles";
        $shipping_costs->save();

        $type = new Type();
        $type->name = "Blanco";
        $type->description = "Tequila blanco";
        $type->save();

        $type = new Type();
        $type->name = "Plata";
        $type->description = "Tequila Plata";
        $type->save();

        $type = new Type();
        $type->name = "Reposado";
        $type->description = "Tequila Reposado";
        $type->save();

        $type = new Type();
        $type->name = "Añejo";
        $type->description = "Tequila Añejo";
        $type->save();

        $type = new Type();
        $type->name = "Extra añejo";
        $type->description = "Tequila Extra añejo";
        $type->save();

        $type = new Type();
        $type->name = "Cristalino";
        $type->description = "Tequila Cristalino";
        $type->save();

        $size = new Size();
        $size->name = "375 ML";
        $size->description = "375 mililitros";
        $size->save();

        $size = new Size();
        $size->name = "695 ML";
        $size->description = "695 mililitros";
        $size->save();

        $size = new Size();
        $size->name = "700 ML";
        $size->description = "700 mililitros";
        $size->save();

        $size = new Size();
        $size->name = "750 ML";
        $size->description = "750 mililitros";
        $size->save();

        $size = new Size();
        $size->name = "950 ML";
        $size->description = "950 mililitros";
        $size->save();

        $size = new Size();
        $size->name = "1 L";
        $size->description = "1 Litro";
        $size->save();

        $size = new Size();
        $size->name = "1.75 L";
        $size->description = "1.75 Litros";
        $size->save();

        $size = new Size();
        $size->name = "2.50 L";
        $size->description = "2.50 Litros";
        $size->save();

        $size = new Size();
        $size->name = "3 L";
        $size->description = "3 Litros";
        $size->save();

        $size = new Size();
        $size->name = "5 L";
        $size->description = "5 Litros";
        $size->save();

        $brand = new Brand();
        $brand->name = "Jose Cuervo";
        $brand->description = "jose cuervo es una empresa....";
        $brand->save();

        $brand = new Brand();
        $brand->name = "Tequila Sauza";
        $brand->description = "Tequila Sauza es una empresa....";
        $brand->save();

        $brand = new Brand();
        $brand->name = "Tequila Orendain";
        $brand->description = "Tequila Orendain es una empresa....";
        $brand->save();

        $category = new Category();
        $category->name = "Tequila";
        $category->description = "Tequila";
        $category->save();

        $category = new Category();
        $category->name = "Licor";
        $category->description = "licor";
        $category->save();

        $category = new Category();
        $category->name = "Artesania";
        $category->description = "artesania";
        $category->save();

    	$cantidadUsuarios = 5;
    	$cantidadCategorias = 30;
    	$cantidadProductos = 30;
    	$cantidadTransacciones = 10;
        // $this->call(UserSeeder::class);

        Factory(User::class, $cantidadUsuarios)->create()->each(function($user){
            Factory(Profile::class)->create([
                  'user_id' => $user->id,
            ]);
        });
        /*Factory(Category::class, $cantidadCategorias)->create();*/
        /*Factory(Product::class, $cantidadProductos)->create()->each(function($product){
        	$categories = Category::all()->random(mt_rand(1,5))->pluck('id');
        	$product->categories()->attach($categories);
        });*/
        /*Factory(Transaction::class, $cantidadTransacciones)->create();*/
    }
}
