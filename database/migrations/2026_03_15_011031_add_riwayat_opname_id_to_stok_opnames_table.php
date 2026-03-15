<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stok_opnames', function (Blueprint $table) {
            $table->foreignId('riwayat_opname_id')
                ->nullable()
                ->after('id')
                ->constrained('riwayat_opnames')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('stok_opnames', function (Blueprint $table) {
            $table->dropConstrainedForeignId('riwayat_opname_id');
        });
    }
};
