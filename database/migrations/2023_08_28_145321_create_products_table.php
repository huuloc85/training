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
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('admin_users');
            $table->string('proName')->unique();
            $table->string('proSlug')->unique();
            $table->string('proImage');
            $table->unsignedBigInteger('proImageDetails');
            $table->foreign('proImageDetails')->references('id')->on('photos_details');
            $table->string('proDetail');
            $table->integer('proPrice');
            $table->integer('proQuantity');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->string('admin_user_added');
            $table->string('admin_user_updated');
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
