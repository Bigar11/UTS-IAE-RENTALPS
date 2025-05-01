<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('console_id');
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable(); // Menambahkan nullable
            $table->timestamps();
        });
    }
    

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
