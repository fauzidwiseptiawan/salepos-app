<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCostumerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('costumer', function (Blueprint $table) {
            $table->increments('id');
            $table->string('costumer_code', 25)->unique();
            $table->string('costumer_name', 25)->unique();
            $table->string('email', 50)->unique()->nullable();
            $table->string('phone', 15)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 25)->nullable();
            $table->string('province', 25)->nullable();
            $table->text('desc')->nullable();
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
        Schema::dropIfExists('costumer');
    }
}
