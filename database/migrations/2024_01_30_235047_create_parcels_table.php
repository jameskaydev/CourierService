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
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->float('width');
            $table->float('height');
            $table->float('length');
            $table->float('weight');
            $table->foreignId('delivery_address_id');
            $table->foreignId('sender_address_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('delivery_address_id')->references('id')->on('addresses');
            $table->foreign('sender_address_id')->references('id')->on('addresses');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcels');
    }
};
