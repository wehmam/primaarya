<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer("user_id");
            $table->integer("product_id");
            $table->string("invoice_no");
            $table->decimal("price_per_product", 15, 2);
            $table->integer("quantity");
            $table->decimal("price_total", 15 ,2);
            $table->string("province");
            $table->string("city");
            $table->string("district");
            $table->integer("post_code");
            $table->string("address");
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
        Schema::dropIfExists('orders');
    }
}
