<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('order_details', function (Blueprint $table) {
    $table->id();

    // PENTING! Ini harus unsignedBigInteger
    $table->unsignedBigInteger('order_id');

    $table->decimal('subtotal', 10, 2);
    $table->timestamps();

    // Foreign key harus refer ke kolom yg cocok (id di orders)
    $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
});


    }

    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
