<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('product_id',10)->primary();
            $table->string('producttype_id');
            $table->foreign('producttype_id')->references('producttype_id')->on('product_type')->onDelete('cascade');
            $table->string('product_name');
            $table->text('product_desc')->nullable();
            $table->text('product_desc0')->nullable();
            $table->text('product_desc1')->nullable();
            $table->string('brand_id');
            $table->foreign('brand_id')->references('brand_id')->on('brand')->onDelete('cascade');
            $table->string('group_id');
            $table->foreign('group_id')->references('group_id')->on('group')->onDelete('cascade');
            $table->string('kind_id');
            $table->foreign('kind_id')->references('kind_id')->on('kind')->onDelete('cascade');
            $table->string('product_price');
            $table->string('product_proprice');
            $table->boolean('product_status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
