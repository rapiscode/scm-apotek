<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPenjualan = Penjualan::where('status', '!=', 'draft')->sum('total_penjualan');
        $returPenjualan = 0;
        $penjualanTertolak = 0;

        $databasePelanggan = 0;
        $databaseSupplier = 0;
        $databaseProduk = Produk::count();
        $databaseDokter = 0;

        $berpotensiRugi = 1;
        $stokNegatif = 0;
        $dekatKadaluarsa = 1;
        $sudahKadaluarsa = 0;

        $tipeProdukChart = [
            'Obat' => Produk::where('tipe_produk', 'Obat')->count(),
            'Alkes' => Produk::where('tipe_produk', 'Alkes')->count(),
            'Umum' => Produk::where('tipe_produk', 'Umum')->count(),
        ];

        // =========================
        // GRAFIK 7 HARI TERAKHIR BERDASARKAN JAM
        // =========================
        $jamLabels = [];
        $jamData = [];

        for ($i = 0; $i < 24; $i++) {
            $jamLabels[] = str_pad($i, 2, '0', STR_PAD_LEFT) . ':00';

            $jumlah = Penjualan::where('status', '!=', 'draft')
                ->whereDate('created_at', '>=', now()->subDays(6)->toDateString())
                ->whereRaw('HOUR(created_at) = ?', [$i])
                ->count();

            $jamData[] = $jumlah;
        }

        // =========================
        // GRAFIK 4 PEKAN TERAKHIR BERDASARKAN HARI
        // =========================
        $hariOrder = [
            'Monday' => 'Sen',
            'Tuesday' => 'Sel',
            'Wednesday' => 'Rab',
            'Thursday' => 'Kam',
            'Friday' => 'Jum',
            'Saturday' => 'Sab',
            'Sunday' => 'Min',
        ];

        $hariDataMap = [
            'Sen' => 0,
            'Sel' => 0,
            'Rab' => 0,
            'Kam' => 0,
            'Jum' => 0,
            'Sab' => 0,
            'Min' => 0,
        ];

        $penjualan4Pekan = Penjualan::where('status', '!=', 'draft')
            ->whereDate('created_at', '>=', now()->subWeeks(4)->toDateString())
            ->get();

        foreach ($penjualan4Pekan as $item) {
            $namaHariEn = Carbon::parse($item->created_at)->format('l');
            $namaHariId = $hariOrder[$namaHariEn] ?? null;

            if ($namaHariId) {
                $hariDataMap[$namaHariId]++;
            }
        }

        $hariLabels = array_keys($hariDataMap);
        $hariData = array_values($hariDataMap);

        return view('Dashboard.index', compact(
            'totalPenjualan',
            'returPenjualan',
            'penjualanTertolak',
            'databasePelanggan',
            'databaseSupplier',
            'databaseProduk',
            'databaseDokter',
            'berpotensiRugi',
            'stokNegatif',
            'dekatKadaluarsa',
            'sudahKadaluarsa',
            'tipeProdukChart',
            'jamLabels',
            'jamData',
            'hariLabels',
            'hariData'
        ));
    }
}