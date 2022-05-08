<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier', function (Blueprint $table) {
            $table->increments('id');
            $table->string('supplier_code', 25)->unique();
            $table->string('supplier_name', 100)->unique();
            $table->string('email', 50)->nullable()->unique();
            $table->string('phone', 15)->nullable();
            $table->text('address')->nullable();
            $table->string('city', 25)->nullable();
            $table->string('province', 25)->nullable();
            $table->string('desc')->nullable();
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
        Schema::dropIfExists('supplier');
    }
}
