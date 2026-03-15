<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gudang_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
            $table->foreignId('produk_id')->constrained('produks')->onDelete('cascade');
            $table->integer('stok')->default(0);
            $table->timestamps();

            $table->unique(['gudang_id', 'produk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gudang_produks');
    }
};

