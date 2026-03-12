<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;
use App\Models\Satuan;
use App\Models\Rak;


class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::latest()->get();

        $produkStats = Produk::selectRaw("
            COUNT(CASE WHEN status_penjualan = 'dijual' THEN 1 END) as dijual,
            COUNT(CASE WHEN status_penjualan = 'tidak_dijual' THEN 1 END) as tidak_dijual
        ")->first();

        $satuans = Satuan::where('status', 'aktif')
            ->orderBy('nama_satuan')
            ->get();

        $raks = Rak::where('status', 'aktif')
            ->orderBy('nama_rak')
            ->get();

        return view('masterdata.produk.masterproduk', compact(
            'produks',
            'produkStats',
            'satuans',
            'raks'
        ));
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
        $filename = time() . '_' . $file->getClientOriginalName();

        $path = $file->storeAs('temp', $filename, 'local');
        $fullPath = Storage::disk('local')->path($path);

        if (!file_exists($fullPath)) {
            return redirect()
                ->route('masterdata.masterproduk')
                ->with('success', 'File upload gagal ditemukan.');
        }

        $rowNumber = 0;

        (new FastExcel)->startRow(1)->sheet(2)->import($fullPath, function ($row) use (&$rowNumber) {
            $rowNumber++;

            // skip baris contoh
            if ($rowNumber === 1) {
                return null;
            }

            if (empty($row['sku *'] ?? null) || empty($row['nama_produk *'] ?? null)) {
                return null;
            }

            if (Produk::where('sku', $row['sku *'])->exists()) {
                return null;
            }

            return Produk::create([
                'tipe_produk'      => $row['tipe_produk *'] ?? 'umum',
                'nama_produk'      => $row['nama_produk *'] ?? null,
                'nama_pabrik'      => $row['nama_pabrik'] ?? null,
                'sku'              => $row['sku *'] ?? null,
                'barcode'          => $row['barcode'] ?? null,
                'pajak'            => $row['pajak'] ?? null,
                'satuan_utama'     => $row['satuan_utama *'] ?? null,
                'harga_beli'       => $row['harga_beli'] ?? 0,
                'harga_jual'       => $row['harga_jual'] ?? 0,
                'stok_minimal'     => $row['stok_minimal'] ?? 0,
                'stok_maksimal'    => $row['stok_maksimal'] ?? 0,
                'rak_penyimpanan'  => $row['rak_penyimpanan'] ?? null,
                'status_penjualan' => $row['status_penjualan *'] ?? 'dijual',
                'catatan'          => $row['catatan'] ?? null,
            ]);
        });

        Storage::disk('local')->delete($path);

        return redirect()
            ->route('masterdata.masterproduk')
            ->with('success', 'Produk berhasil diimport.');
    }

    public function exportEditTemplate()
    {
        $produks = Produk::select([
            'id',
            'tipe_produk',
            'nama_produk',
            'nama_pabrik',
            'sku',
            'barcode',
            'pajak',
            'satuan_utama',
            'harga_beli',
            'harga_jual',
            'stok_minimal',
            'stok_maksimal',
            'rak_penyimpanan',
            'status_penjualan',
            'catatan',
        ])->get();

        $fileName = 'edit_produk_' . now()->format('Ymd_His') . '.xlsx';
        $filePath = storage_path('app/temp/' . $fileName);

        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0777, true);
        }

        (new FastExcel($produks))->export($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function importUpdate(Request $request)
    {
        $request->validate([
            'file_edit_produk' => 'required|file|mimes:xlsx,xls|max:5120',
        ]);

        $fullPath = $request->file('file_edit_produk')->getRealPath();

        (new FastExcel)->import($fullPath, function ($row) {
            $id = $row['id'] ?? null;
            $sku = $row['sku'] ?? null;

            if (empty($id) && empty($sku)) {
                return null;
            }

            $produk = null;

            if (!empty($id)) {
                $produk = Produk::find($id);
            }

            if (!$produk && !empty($sku)) {
                $produk = Produk::where('sku', $sku)->first();
            }

            if (!$produk) {
                return null;
            }

            $produk->update([
                'tipe_produk'      => $row['tipe_produk'] ?? $produk->tipe_produk,
                'nama_produk'      => $row['nama_produk'] ?? $produk->nama_produk,
                'nama_pabrik'      => $row['nama_pabrik'] ?? $produk->nama_pabrik,
                'sku'              => $row['sku'] ?? $produk->sku,
                'barcode'          => $row['barcode'] ?? $produk->barcode,
                'pajak'            => $row['pajak'] ?? $produk->pajak,
                'satuan_utama'     => $row['satuan_utama'] ?? $produk->satuan_utama,
                'harga_beli'       => is_numeric($row['harga_beli'] ?? null) ? $row['harga_beli'] : $produk->harga_beli,
                'harga_jual'       => is_numeric($row['harga_jual'] ?? null) ? $row['harga_jual'] : $produk->harga_jual,
                'stok_minimal'     => is_numeric($row['stok_minimal'] ?? null) ? $row['stok_minimal'] : $produk->stok_minimal,
                'stok_maksimal'    => is_numeric($row['stok_maksimal'] ?? null) ? $row['stok_maksimal'] : $produk->stok_maksimal,
                'rak_penyimpanan'  => $row['rak_penyimpanan'] ?? $produk->rak_penyimpanan,
                'status_penjualan' => $row['status_penjualan'] ?? $produk->status_penjualan,
                'catatan'          => $row['catatan'] ?? $produk->catatan,
            ]);

            return $produk; 
        });

        return redirect()
            ->route('masterdata.masterproduk')
            ->with('success', 'Produk berhasil diperbarui secara massal.');
    }

    public function downloadAllProduk()
    {
        $produks = Produk::select([
            'id',
            'tipe_produk',
            'nama_produk',
            'nama_pabrik',
            'sku',
            'barcode',
            'pajak',
            'satuan_utama',
            'harga_beli',
            'harga_jual',
            'stok_minimal',
            'stok_maksimal',
            'rak_penyimpanan',
            'status_penjualan',
            'catatan',
            'created_at',
            'updated_at',
        ])->get()->map(function ($produk) {
            return [
                'ID' => $produk->id,
                'Tipe Produk' => $produk->tipe_produk,
                'Nama Produk' => $produk->nama_produk,
                'Nama Pabrik' => $produk->nama_pabrik,
                'SKU' => $produk->sku,
                'Barcode' => $produk->barcode,
                'Pajak' => $produk->pajak,
                'Satuan Utama' => $produk->satuan_utama,
                'Harga Beli' => $produk->harga_beli,
                'Harga Jual' => $produk->harga_jual,
                'Stok Minimal' => $produk->stok_minimal,
                'Stok Maksimal' => $produk->stok_maksimal,
                'Rak Penyimpanan' => $produk->rak_penyimpanan,
                'Status Penjualan' => $produk->status_penjualan,
                'Catatan' => $produk->catatan,
                'Dibuat Pada' => optional($produk->created_at)->format('Y-m-d H:i:s'),
                'Diubah Pada' => optional($produk->updated_at)->format('Y-m-d H:i:s'),
            ];
        });

        $fileName = 'master_produk_' . now()->format('Ymd_His') . '.xlsx';
        $tempDir = storage_path('app/temp');

        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $filePath = $tempDir . DIRECTORY_SEPARATOR . $fileName;

        (new FastExcel($produks))->export($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}