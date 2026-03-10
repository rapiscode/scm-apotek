<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('tipe_produk')->default('umum');
            $table->string('nama_produk');
            $table->string('nama_pabrik')->nullable();
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();
            $table->string('pajak')->nullable();
            $table->string('satuan_utama');
            $table->decimal('harga_beli', 15, 2)->default(0);
            $table->decimal('harga_jual', 15, 2)->default(0);
            $table->integer('stok_minimal')->default(0);
            $table->integer('stok_maksimal')->default(0);
            $table->string('rak_penyimpanan')->nullable();
            $table->string('status_penjualan')->default('dijual');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};