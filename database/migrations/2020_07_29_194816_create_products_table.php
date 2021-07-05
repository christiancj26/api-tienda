<?php

use App\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description', 1000);
            $table->integer('quantity')->unsigned();
            $table->double('price', 8, 2)->unsigned();
            $table->double('discount', 8, 2)->unsigned()->default(0);
            $table->string('status')->default(Product::PRODUCT_AVIALABLE);
            $table->string('image');
            $table->foreignId('seller_id')->constrained('users');
            $table->foreignId('type_id')->nullable()->constrained('types');
            $table->foreignId('size_id')->nullable()->constrained('sizes');
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
