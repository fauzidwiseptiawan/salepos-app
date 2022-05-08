<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->nullable();
            $table->foreign('item_id')->references('id')->on('item');
            $table->unsignedInteger('item_batch_id')->nullable();
            $table->foreign('item_batch_id')->references('id')->on('item_batches');
            $table->string('qty', 25)->nullable();
            $table->string('recieved', 25)->nullable();
            $table->string('discount', 25)->nullable();
            $table->string('total', 25)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_purchases');
    }
};
