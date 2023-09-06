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
            $table->id();
            $table->unsignedBigInteger('user_added');
            $table->foreign('user_added')->references('id')->on('users');
            $table->unsignedBigInteger('user_updated');
            $table->foreign('user_updated')->references('id')->on('users');
            $table->string('proName')->unique();
            $table->string('proSlug')->unique();
            $table->string('proImage');
            $table->string('proDetail');
            $table->integer('proPrice');
            $table->integer('proQuantity');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
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
