<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\Persediaan\DaftarProdukController;
use App\Models\Produk;
use App\Models\PenyesuaianStok;
use Illuminate\Http\Request;
use App\Models\Rak;
use App\Models\StokOpname;
use App\Models\Gudang;
use App\Models\GudangProduk;


Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::redirect('/', '/dashboard');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/master-data/master-produk', [ProdukController::class, 'index'])->name('masterdata.masterproduk');
    Route::post('/master-data/master-produk', [ProdukController::class, 'store'])->name('masterdata.masterproduk.store');

    Route::get('/master-data/master-produk/template/download', [ProdukController::class, 'downloadTemplate'])
        ->name('masterdata.masterproduk.template.download');

    Route::post('/master-data/master-produk/import', [ProdukController::class, 'import'])
    ->name('masterdata.masterproduk.import');

    Route::get('/master-data/master-produk/download', [ProdukController::class, 'downloadAllProduk'])
    ->name('masterdata.masterproduk.download');

    Route::get('/master-data/master-produk/export', [ProdukController::class, 'exportEditTemplate'])
    ->name('masterdata.masterproduk.export');

    Route::post('/master-data/master-produk/import-update', [ProdukController::class, 'importUpdate'])
        ->name('masterdata.masterproduk.importUpdate');

    Route::put('/master-data/master-produk/{produk}', [ProdukController::class, 'update'])->name('masterdata.masterproduk.update');
    Route::delete('/master-data/master-produk/{produk}', [ProdukController::class, 'destroy'])->name('masterdata.masterproduk.destroy');

    Route::get('/master-data/master-satuan', [SatuanController::class, 'index'])->name('masterdata.mastersatuan');
    Route::post('/master-data/master-satuan', [SatuanController::class, 'store'])->name('masterdata.mastersatuan.store');
    Route::put('/master-data/master-satuan/{satuan}', [SatuanController::class, 'update'])->name('masterdata.mastersatuan.update');
    Route::delete('/master-data/master-satuan/{satuan}', [SatuanController::class, 'destroy'])->name('masterdata.mastersatuan.destroy');

    Route::post('/master-data/master-satuan/ajax-store', [SatuanController::class, 'ajaxStore'])
        ->name('masterdata.mastersatuan.ajaxStore');

    Route::get('/master-data/master-rak', [RakController::class, 'index'])->name('masterdata.masterrak');
    Route::post('/master-data/master-rak', [RakController::class, 'store'])->name('masterdata.masterrak.store');
    Route::put('/master-data/master-rak/{rak}', [RakController::class, 'update'])->name('masterdata.masterrak.update');
    Route::delete('/master-data/master-rak/{rak}', [RakController::class, 'destroy'])->name('masterdata.masterrak.destroy');

    Route::get('/master-data/master-gudang', [GudangController::class, 'index'])->name('masterdata.mastergudang');
    Route::post('/master-data/master-gudang', [GudangController::class, 'store'])->name('masterdata.mastergudang.store');
    Route::put('/master-data/master-gudang/{gudang}', [GudangController::class, 'update'])->name('masterdata.mastergudang.update');
    Route::delete('/master-data/master-gudang/{gudang}', [GudangController::class, 'destroy'])->name('masterdata.mastergudang.destroy');

    Route::get('/persediaan/daftar-produk', [DaftarProdukController::class, 'index'])
    ->name('persediaan.daftarproduk');

    Route::post('/persediaan/daftar-produk', [DaftarProdukController::class, 'store'])
        ->name('persediaan.daftarproduk.store');

    Route::delete('/persediaan/stok-produk/{id}', function ($id) {

        PenyesuaianStok::findOrFail($id)->delete();

        return redirect()->route('persediaan.stokproduk')
            ->with('success','Data berhasil dihapus');

    })->name('persediaan.stokproduk.destroy');

    Route::get('/persediaan/stok-produk', function (Request $request) {
        $produks = Produk::orderBy('nama_produk')->get();
        $raks = Rak::orderBy('nama_rak')->get();

        $search = $request->search;
        $tanggalAwal = $request->tanggal_awal;
        $tanggalAkhir = $request->tanggal_akhir;
        $status = $request->status;
        $rak = $request->rak;

        $stokProduks = PenyesuaianStok::with('produk')
            ->when($search, function ($query) use ($search) {
                $query->where('catatan', 'like', '%' . $search . '%')
                    ->orWhere('tanggal', 'like', '%' . $search . '%')
                    ->orWhereHas('produk', function ($q) use ($search) {
                        $q->where('nama_produk', 'like', '%' . $search . '%')
                        ->orWhere('sku', 'like', '%' . $search . '%');
                    });
            })
            ->when($tanggalAwal, function ($query) use ($tanggalAwal) {
                $query->whereDate('tanggal', '>=', $tanggalAwal);
            })
            ->when($tanggalAkhir, function ($query) use ($tanggalAkhir) {
                $query->whereDate('tanggal', '<=', $tanggalAkhir);
            })
            ->when($status, function ($query) use ($status) {
                $query->whereHas('produk', function ($q) use ($status) {
                    $q->where('status_penjualan', $status);
                });
            })
            ->when($rak, function ($query) use ($rak) {
                $query->whereHas('produk', function ($q) use ($rak) {
                    $q->where('rak_penyimpanan', $rak);
                });
            })
            ->latest()
            ->get();

        return view('Persediaan.stokproduk', compact('produks', 'stokProduks', 'raks'));
    })->name('persediaan.stokproduk');

    Route::post('/persediaan/stok-produk/simpan', function (Request $request) {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'tanggal' => 'required|date',
            'stok_fisik' => 'required|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        PenyesuaianStok::create($validated);

        $produk = Produk::findOrFail($validated['produk_id']);
        $produk->update([
            'stok' => $produk->stok + $validated['stok_fisik'],
        ]);

        return redirect()->route('persediaan.stokproduk')
            ->with('success', 'Penyesuaian stok berhasil disimpan.');
    })->name('persediaan.stokproduk.store');

    Route::delete('/persediaan/stok-produk/{id}', function ($id) {
        PenyesuaianStok::findOrFail($id)->delete();

        return redirect()->route('persediaan.stokproduk')
            ->with('success', 'Data berhasil dihapus');
    })->name('persediaan.stokproduk.destroy');

    Route::get('/persediaan/stokopname', function (Request $request) {

        $mode = $request->get('mode', 'empty');
        $search = $request->get('search');

        $currentOpname = null;
        $riwayatOpnames = collect();

        if ($mode === 'active') {
            $currentOpname = \App\Models\RiwayatOpname::firstOrCreate(
                ['status' => 'open'],
                [
                    'kode_opname' => 'SO' . now()->format('ymdHis'),
                    'tanggal_mulai' => now(),
                ]
            );
        }

        if ($mode === 'history') {
            $riwayatOpnames = \App\Models\RiwayatOpname::withCount('detailOpnames')
                ->when($search, function ($query) use ($search) {
                    $query->where('kode_opname', 'like', '%' . $search . '%');
                })
                ->where('status', 'closed')
                ->latest('tanggal_selesai')
                ->get();
        }

        // dropdown atas
        $filterOpname = $request->get('filter_opname', 'semua');

        // modal filter
        $filterStatusProduk = $request->get('filter_status_produk', 'semua');
        $filterStatusStok = $request->get('filter_status_stok', 'semua');
        $filterStatusOpname = $request->get('filter_status_opname', 'semua');
        $filterRak = $request->get('filter_rak', 'semua');

        $raks = Rak::orderBy('nama_rak')->get();

        $produks = collect();

        if ($mode === 'active') {
            $produks = Produk::with(['stokOpname' => function ($q) use ($currentOpname) {
                $q->where('riwayat_opname_id', $currentOpname->id);
            }])
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('nama_produk', 'like', '%' . $search . '%')
                        ->orWhere('sku', 'like', '%' . $search . '%')
                        ->orWhere('rak_penyimpanan', 'like', '%' . $search . '%');
                    });
                })

                ->when($filterOpname === 'sudah', function ($query) {
                    $query->whereHas('stokOpname');
                })
                ->when($filterOpname === 'perlu', function ($query) {
                    $query->whereHas('stokOpname', function ($q) {
                        $q->where('selisih', '!=', 0);
                    });
                })

                ->when($filterStatusProduk !== 'semua', function ($query) use ($filterStatusProduk) {
                    $query->where('status_penjualan', $filterStatusProduk);
                })

                ->when($filterStatusStok === 'habis', function ($query) {
                    $query->where('stok', '<=', 0);
                })
                ->when($filterStatusStok === 'rendah', function ($query) {
                    $query->whereColumn('stok', '<=', 'stok_minimal')
                        ->where('stok', '>', 0);
                })
                ->when($filterStatusStok === 'aman', function ($query) {
                    $query->whereColumn('stok', '>', 'stok_minimal');
                })

                ->when($filterStatusOpname === 'belum', function ($query) {
                    $query->whereDoesntHave('stokOpname');
                })
                ->when($filterStatusOpname === 'sudah', function ($query) {
                    $query->whereHas('stokOpname');
                })
                ->when($filterStatusOpname === 'selisih', function ($query) {
                    $query->whereHas('stokOpname', function ($q) {
                        $q->where('selisih', '!=', 0);
                    });
                })

                ->when($filterRak !== 'semua', function ($query) use ($filterRak) {
                    $query->where('rak_penyimpanan', $filterRak);
                })

                ->orderBy('nama_produk')
                ->get();
        }

        return view('Persediaan.stokopname', compact(
            'produks',
            'mode',
            'raks',
            'currentOpname',
            'riwayatOpnames'
        ));
    })->name('persediaan.stokopname');

    Route::post('/persediaan/stokopname/simpan', function (Request $request) {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'stok_fisik' => 'required|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        $currentOpname = \App\Models\RiwayatOpname::where('status', 'open')->latest()->first();

        if (!$currentOpname) {
            $currentOpname = \App\Models\RiwayatOpname::create([
                'kode_opname' => 'SO' . now()->format('ymdHis'),
                'tanggal_mulai' => now(),
                'status' => 'open',
            ]);
        }

        $produk = Produk::findOrFail($validated['produk_id']);
        $stokSistem = $produk->stok ?? 0;
        $selisih = $validated['stok_fisik'] - $stokSistem;

        StokOpname::updateOrCreate(
            [
                'produk_id' => $validated['produk_id'],
                'riwayat_opname_id' => $currentOpname->id,
            ],
            [
                'stok_fisik' => $validated['stok_fisik'],
                'selisih' => $selisih,
                'catatan' => $validated['catatan'] ?? null,
                'waktu_opname' => now(),
            ]
        );

        return redirect()->route('persediaan.stokopname', ['mode' => 'active'])
            ->with('success', 'Opname berhasil disimpan.');
    })->name('persediaan.stokopname.store');


    Route::post('/persediaan/stokopname/tutup', function () {

        $currentOpname = \App\Models\RiwayatOpname::where('status', 'open')->latest()->first();

        if ($currentOpname) {
            $currentOpname->update([
                'status' => 'closed',
                'tanggal_selesai' => now(),
            ]);
        }

        return redirect()->route('persediaan.stokopname', ['mode' => 'history'])
            ->with('success', 'Opname berhasil ditutup dan masuk ke riwayat.');

    })->name('persediaan.stokopname.tutup');

    Route::prefix('control-user')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');

        Route::get('/custom-priv', function () {
            $roles = collect([
                (object) ['name' => 'admin', 'is_active' => true],
                (object) ['name' => 'user', 'is_active' => true],
                (object) ['name' => 'kasir', 'is_active' => true],
            ]);

            return view('users.hakakses.custompriv', compact('roles'));
        })->name('custompriv');

        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::patch('/{user}/toggle', [UserManagementController::class, 'toggle'])->name('toggle');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    Route::get('/penjualan/kasir', function () {
        return view('Penjualan.kasir');
    })->name('penjualan.kasir');

    Route::get('/persediaan/gudang-penyimpanan', function (Request $request) {
        $gudangs = Gudang::orderBy('nama_gudang')->get();

        $selectedGudangId = $request->get('gudang_id');
        $selectedGudang = null;
        $produkGudang = collect();
        $produks = Produk::orderBy('nama_produk')->get();

        if ($selectedGudangId) {
            $selectedGudang = Gudang::with(['produkGudangs.produk'])->find($selectedGudangId);

            if ($selectedGudang) {
                $produkGudang = $selectedGudang->produkGudangs;
            }
        }

        return view('Persediaan.gudangpenyimpanan', compact(
            'gudangs',
            'selectedGudang',
            'selectedGudangId',
            'produkGudang',
            'produks'
        ));
    })->name('persediaan.gudangpenyimpanan');

    Route::post('/persediaan/gudang-penyimpanan/store', function (Request $request) {
        $validated = $request->validate([
            'gudang_id' => 'required|exists:gudangs,id',
            'produk_id' => 'required|exists:produks,id',
            'stok' => 'nullable|integer|min:0',
        ]);

        GudangProduk::updateOrCreate(
            [
                'gudang_id' => $validated['gudang_id'],
                'produk_id' => $validated['produk_id'],
            ],
            [
                'stok' => $validated['stok'] ?? 0,
            ]
        );

        return redirect()->route('persediaan.gudangpenyimpanan', [
            'gudang_id' => $validated['gudang_id']
        ])->with('success', 'Produk berhasil dimasukkan ke gudang.');
    })->name('persediaan.gudangpenyimpanan.store');

    Route::delete('/persediaan/gudang-penyimpanan/{id}', function ($id) {
        $item = GudangProduk::findOrFail($id);
        $gudangId = $item->gudang_id;
        $item->delete();

        return redirect()->route('persediaan.gudangpenyimpanan', [
            'gudang_id' => $gudangId
        ])->with('success', 'Produk berhasil dihapus dari gudang.');
    })->name('persediaan.gudangpenyimpanan.destroy');

    Route::get('/penjualan/kasir/search-produk', function (Illuminate\Http\Request $request) {
        $q = trim($request->get('q', ''));

        if ($q === '') {
            return response()->json([]);
        }

        $produks = \App\Models\Produk::query()
            ->where(function ($query) use ($q) {
                $query->where('nama_produk', 'like', "%{$q}%")
                    ->orWhere('sku', 'like', "%{$q}%")
                    ->orWhere('barcode', 'like', "%{$q}%");
            })
            ->orderBy('nama_produk')
            ->limit(10)
            ->get([
                'id',
                'nama_produk',
                'sku',
                'barcode',
                'harga_jual',
                'satuan_utama',
                'stok',
            ]);

        return response()->json($produks);
    })->name('penjualan.kasir.search');


});