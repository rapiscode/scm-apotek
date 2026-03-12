<?php

namespace App\Http\Controllers\Persediaan;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Satuan;
use App\Models\Rak;
use Illuminate\Http\Request;

class DaftarProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::latest()->get();
        $satuans = Satuan::where('status', 'aktif')->orderBy('nama_satuan')->get();
        $raks = Rak::where('status', 'aktif')->orderBy('nama_rak')->get();

        return view('Persediaan.daftarproduk', compact('produks', 'satuans', 'raks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_produk' => 'required|string|max:50',
            'nama_produk' => 'required|string|max:255',
            'nama_pabrik' => 'nullable|string|max:255',
            'sku' => 'required|string|max:255|unique:produks,sku',
            'barcode' => 'nullable|string|max:255',
            'pajak' => 'nullable|string|max:50',
            'satuan_utama' => 'required|string|max:100',
            'harga_beli' => 'nullable|numeric|min:0',
            'harga_jual' => 'nullable|numeric|min:0',
            'stok_minimal' => 'nullable|integer|min:0',
            'stok_maksimal' => 'nullable|integer|min:0',
            'rak_penyimpanan' => 'nullable|string|max:255',
            'status_penjualan' => 'required|string|in:dijual,tidak_dijual',
            'catatan' => 'nullable|string',
        ]);

        Produk::create([
            'tipe_produk'      => $validated['tipe_produk'],
            'nama_produk'      => $validated['nama_produk'],
            'nama_pabrik'      => $validated['nama_pabrik'] ?? null,
            'sku'              => $validated['sku'],
            'barcode'          => $validated['barcode'] ?? null,
            'pajak'            => $validated['pajak'] ?? null,
            'satuan_utama'     => $validated['satuan_utama'],
            'harga_beli'       => $validated['harga_beli'] ?? 0,
            'harga_jual'       => $validated['harga_jual'] ?? 0,
            'stok_minimal'     => $validated['stok_minimal'] ?? 0,
            'stok_maksimal'    => $validated['stok_maksimal'] ?? 0,
            'rak_penyimpanan'  => $validated['rak_penyimpanan'] ?? null,
            'status_penjualan' => $validated['status_penjualan'],
            'catatan'          => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('persediaan.daftarproduk')
            ->with('success', 'Produk berhasil ditambahkan.');
    }
}