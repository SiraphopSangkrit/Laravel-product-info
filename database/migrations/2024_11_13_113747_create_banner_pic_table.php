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
        Schema::create('banner_pic', function (Blueprint $table) {
            $table->id('bannerPic_id');
            $table->bigInteger('banner_id')->unsigned();
            $table->foreign('banner_id')->references('banner_id')->on('banner')->onDelete('cascade');
            $table->bigInteger('picture_id')->unsigned();
            $table->foreign('picture_id')->references('picture_id')->on('pictures')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_banner_pic');
    }
};
