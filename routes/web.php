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
});