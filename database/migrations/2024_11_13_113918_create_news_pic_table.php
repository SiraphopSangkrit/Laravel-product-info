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
        Schema::create('news_pic', function (Blueprint $table) {
            $table->id('newsPic_id');
            $table->bigInteger('news_id')->unsigned();
            $table->foreign('news_id')->references('news_id')->on('news')->onDelete('cascade');
            $table->string('asset_url')->nullable();
            $table->string('public_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_pic');
    }
};
