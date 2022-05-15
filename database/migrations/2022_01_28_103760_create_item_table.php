<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id')->nullable()->unsigned();
            $table->foreign('type_id')->references('id')->on('type');
            $table->integer('subtype_id')->nullable()->unsigned();
            $table->foreign('subtype_id')->references('id')->on('subtype');
            $table->integer('brand_id')->nullable()->unsigned();
            $table->foreign('brand_id')->references('id')->on('brand');
            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('unit');
            $table->integer('supplier_id')->nullable()->unsigned();
            $table->foreign('supplier_id')->references('id')->on('supplier');
            $table->string('item_type', 50)->nullable();
            $table->string('item_code', 10)->unique();
            $table->string('item_name', 50)->unique();
            $table->enum('sale_status', ['Still For Sale', 'Not Sold']);
            $table->string('barcode', 25)->unique()->nullable();
            $table->string('stock', 25)->nullable();
            $table->string('purchase_price', 25)->nullable();
            $table->string('selling_price', 25)->nullable();
            $table->string('rack', 25)->nullable();
            $table->integer('minimum_stock')->nullable();
            $table->string('tax_include', 25)->nullable();
            $table->boolean('is_batch')->nullable();
            $table->boolean('promotion')->nullable();
            $table->string('promotion_price', 25)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('desc')->nullable();
            $table->text('image')->nullable();
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
        Schema::dropIfExists('item');
    }
}
