<?php

namespace App\Providers;

use App\Models\DetailPenjualan;
use App\Models\Gudang;
use App\Models\GudangProduk;
use App\Models\Penjualan;
use App\Models\PenyesuaianStok;
use App\Models\Produk;
use App\Models\Rak;
use App\Models\RiwayatOpname;
use App\Models\Satuan;
use App\Models\StokOpname;
use App\Models\User;
use App\Services\FirestoreSyncService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FirestoreSyncService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $models = [
            User::class,
            Produk::class,
            Satuan::class,
            Rak::class,
            Gudang::class,
            GudangProduk::class,
            PenyesuaianStok::class,
            RiwayatOpname::class,
            StokOpname::class,
            Penjualan::class,
            DetailPenjualan::class,
        ];

        foreach ($models as $modelClass) {
            $modelClass::saved(function (Model $model) {
                app(FirestoreSyncService::class)->syncModel($model);
            });

            $modelClass::deleted(function (Model $model) {
                app(FirestoreSyncService::class)->deleteModel($model);
            });
        }
    }
}
