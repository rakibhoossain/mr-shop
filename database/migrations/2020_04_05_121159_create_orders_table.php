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
            $table->string('code', 170)->unique();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('shipping_method_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('shipping_method_id')->references('id')->on('shipping_methods');

            $table->enum('status', ['pending', 'processing', 'completed', 'decline'])->default('pending');

            $table->string('first_name');
            $table->string('last_name');
            $table->text('address');
            $table->string('city');
            $table->string('country');
            $table->string('post_code');
            $table->string('phone_number');
            $table->string('alternative_number')->nullable();
            $table->text('shipping_address')->nullable();
            $table->text('notes')->nullable();

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
        Schema::dropIfExists('orders');
    }
}
