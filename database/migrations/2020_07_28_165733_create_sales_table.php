<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_id')->constrained('users');
            $table->string('number_order');
            $table->string('voucher');
            $table->integer('tax')->nullable();
            $table->double('subtotal', 8, 2)->unsigned();
            $table->double('discount', 8, 2)->unsigned();
            $table->double('shipping_costs', 8, 2)->unsigned();
            $table->double('total', 8, 2)->unsigned();
            $table->enum('status', ['pendiente','realizado', 'cancelado']);
            $table->text('observation')->nullable();
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
        Schema::dropIfExists('sales');
    }
}
