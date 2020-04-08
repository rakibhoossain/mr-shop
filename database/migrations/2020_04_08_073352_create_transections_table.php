<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transections', function (Blueprint $table) {
            $table->id();

            $table->integer('transectionable_id');
            $table->string("transectionable_type");

            $table->enum('type', ['stripe', 'cash', 'bKash', 'rocket', 'card'])->default('cash');
            $table->text('TxnId')->nullable();
            $table->decimal('amount', 20, 2)->nullable()->default(0);
            $table->enum('status', ['unpaid', 'processing', 'paid', 'decline'])->default('unpaid');
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
        Schema::dropIfExists('transections');
    }
}
