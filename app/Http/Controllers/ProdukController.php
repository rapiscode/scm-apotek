<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::latest()->get();

        return view('masterdata.produk.masterproduk', compact('produks'));
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
            'tipe_produk' => $validated['tipe_produk'],
            'nama_produk' => $validated['nama_produk'],
            'nama_pabrik' => $validated['nama_pabrik'] ?? null,
            'sku' => $validated['sku'],
            'barcode' => $validated['barcode'] ?? null,
            'pajak' => $validated['pajak'] ?? null,
            'satuan_utama' => $validated['satuan_utama'],
            'harga_beli' => $validated['harga_beli'] ?? 0,
            'harga_jual' => $validated['harga_jual'] ?? 0,
            'stok_minimal' => $validated['stok_minimal'] ?? 0,
            'stok_maksimal' => $validated['stok_maksimal'] ?? 0,
            'rak_penyimpanan' => $validated['rak_penyimpanan'] ?? null,
            'status_penjualan' => $validated['status_penjualan'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('masterdata.masterproduk')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'tipe_produk' => 'required|string|max:50',
            'nama_produk' => 'required|string|max:255',
            'nama_pabrik' => 'nullable|string|max:255',
            'sku' => 'required|string|max:255|unique:produks,sku,' . $produk->id,
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

        $produk->update([
            'tipe_produk' => $validated['tipe_produk'],
            'nama_produk' => $validated['nama_produk'],
            'nama_pabrik' => $validated['nama_pabrik'] ?? null,
            'sku' => $validated['sku'],
            'barcode' => $validated['barcode'] ?? null,
            'pajak' => $validated['pajak'] ?? null,
            'satuan_utama' => $validated['satuan_utama'],
            'harga_beli' => $validated['harga_beli'] ?? 0,
            'harga_jual' => $validated['harga_jual'] ?? 0,
            'stok_minimal' => $validated['stok_minimal'] ?? 0,
            'stok_maksimal' => $validated['stok_maksimal'] ?? 0,
            'rak_penyimpanan' => $validated['rak_penyimpanan'] ?? null,
            'status_penjualan' => $validated['status_penjualan'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('masterdata.masterproduk')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()
            ->route('masterdata.masterproduk')
            ->with('success', 'Produk berhasil dihapus.');
    }

    public function downloadTemplate()
    {
        $path = storage_path('app/public/templates/template_import_produk.xlsx');

        if (!file_exists($path)) {
            abort(404, 'File template tidak ditemukan.');
        }

        return response()->download($path, 'template_import_produk.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file_import' => 'required|file|mimes:xlsx,xls|max:5120',
        ]);

        $file = $request->file('file_import');
        $path = $file->storeAs('temp', $file->getClientOriginalName());

        (new FastExcel)->startRow(2)->sheet(2)->import(storage_path('app/private/' . $path), function ($row) {
            if (empty($row['sku']) || empty($row['nama_produk'])) {
                return null;
            }

            if (Produk::where('sku', $row['sku'])->exists()) {
                return null;
            }

            return Produk::create([
                'tipe_produk'      => $row['tipe_produk'] ?? 'umum',
                'nama_produk'      => $row['nama_produk'],
                'nama_pabrik'      => $row['nama_pabrik'] ?? null,
                'sku'              => $row['sku'],
                'barcode'          => $row['barcode'] ?? null,
                'pajak'            => $row['pajak'] ?? null,
                'satuan_utama'     => $row['satuan_utama'],
                'harga_beli'       => $row['harga_beli'] ?? 0,
                'harga_jual'       => $row['harga_jual'] ?? 0,
                'stok_minimal'     => $row['stok_minimal'] ?? 0,
                'stok_maksimal'    => $row['stok_maksimal'] ?? 0,
                'rak_penyimpanan'  => $row['rak_penyimpanan'] ?? null,
                'status_penjualan' => $row['status_penjualan'] ?? 'dijual',
                'catatan'          => $row['catatan'] ?? null,
            ]);
        });

        \Storage::delete('temp/' . $file->getClientOriginalName());

        return redirect()
            ->route('masterdata.masterproduk')
            ->with('success', 'Produk berhasil diimport.');
    }
}