<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('firebase:sync-firestore', function (\App\Services\FirestoreSyncService $firestore) {
    if (! $firestore->enabled()) {
        $this->error('Firebase belum aktif. Pastikan FIREBASE_CREDENTIALS mengarah ke file JSON service account yang valid.');
        return 1;
    }

    $models = [
        \App\Models\User::class,
        \App\Models\Produk::class,
        \App\Models\Satuan::class,
        \App\Models\Rak::class,
        \App\Models\Gudang::class,
        \App\Models\GudangProduk::class,
        \App\Models\PenyesuaianStok::class,
        \App\Models\RiwayatOpname::class,
        \App\Models\StokOpname::class,
        \App\Models\Penjualan::class,
        \App\Models\DetailPenjualan::class,
    ];

    foreach ($models as $modelClass) {
        $this->info('Sync: ' . $modelClass);
        $modelClass::query()->chunkById(100, function ($items) use ($firestore) {
            foreach ($items as $item) {
                $firestore->syncModel($item);
            }
        });
    }

    $this->info('Selesai sync ke Firestore.');
    return 0;
})->purpose('Sinkronkan data MySQL yang sudah ada ke Firebase Firestore.');
