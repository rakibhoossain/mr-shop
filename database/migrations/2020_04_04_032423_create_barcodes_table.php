<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarcodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barcodes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 170);
            $table->string('slug', 190)->index();
            $table->text('description')->nullable();
            $table->float('width', 8, 2)->nullable()->default(0);
            $table->float('height', 8, 2)->nullable()->default(0);
            $table->float('paper_width', 8, 2)->nullable()->default(0);
            $table->float('paper_height', 8, 2)->nullable()->default(0);
            $table->float('top_margin', 8, 2)->nullable()->default(0);
            $table->float('left_margin', 8, 2)->nullable()->default(0);
            $table->float('row_distance', 8, 2)->nullable()->default(0);
            $table->float('col_distance', 8, 2)->nullable()->default(0);
            $table->integer('stickers_in_one_row')->nullable()->default(0);
            $table->boolean('is_default')->nullable()->default(0);
            $table->boolean('is_continuous')->nullable()->default(0);
            $table->integer('stickers_in_one_sheet')->nullable();
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
        Schema::dropIfExists('barcodes');
    }
}
