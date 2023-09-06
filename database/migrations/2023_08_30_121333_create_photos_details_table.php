<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('photos_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proImageDetails');
            $table->foreign('proImageDetails')->references('id')->on('products');
            $table->string('photos');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos_details');
    }
};
