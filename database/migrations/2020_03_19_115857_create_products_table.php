<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->string('code', 170);
            $table->string('name', 170);
            $table->string('slug', 190);
            $table->decimal('price', 20, 2)->nullable();
            $table->decimal('sell_price', 20, 2)->nullable();
            $table->decimal('purchase_price', 20, 2)->nullable();
            $table->decimal('quantity', 20, 2)->nullable()->default(0);
            $table->integer('alert_quantity')->default(1)->nullable();
            $table->text('description')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('meta')->nullable();
            $table->unsignedInteger('brand_id')->nullable();
            $table->unsignedInteger('admin_id');
            $table->softDeletes();
            $table->timestamps();
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
