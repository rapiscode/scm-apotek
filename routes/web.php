<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\Persediaan\DaftarProdukController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RakController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\UserManagementController;
use App\Mail\MintaBantuanMail;
use App\Mail\UsulanFiturMail;
use App\Services\FirestoreService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Rap2hpoutre\FastExcel\FastExcel;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', fn () => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');
Route::redirect('/', '/dashboard');

Route::middleware(['firebase.session'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/master-data/master-produk', [ProdukController::class, 'index'])->name('masterdata.masterproduk');
    Route::post('/master-data/master-produk', [ProdukController::class, 'store'])->name('masterdata.masterproduk.store');
    Route::get('/master-data/master-produk/template/download', [ProdukController::class, 'downloadTemplate'])->name('masterdata.masterproduk.template.download');
    Route::post('/master-data/master-produk/import', [ProdukController::class, 'import'])->name('masterdata.masterproduk.import');
    Route::get('/master-data/master-produk/download', [ProdukController::class, 'downloadAllProduk'])->name('masterdata.masterproduk.download');
    Route::get('/master-data/master-produk/export', [ProdukController::class, 'exportEditTemplate'])->name('masterdata.masterproduk.export');
    Route::post('/master-data/master-produk/import-update', [ProdukController::class, 'importUpdate'])->name('masterdata.masterproduk.importUpdate');
    Route::put('/master-data/master-produk/{produk}', [ProdukController::class, 'update'])->name('masterdata.masterproduk.update');
    Route::delete('/master-data/master-produk/{produk}', [ProdukController::class, 'destroy'])->name('masterdata.masterproduk.destroy');

    Route::get('/master-data/master-satuan', [SatuanController::class, 'index'])->name('masterdata.mastersatuan');
    Route::post('/master-data/master-satuan', [SatuanController::class, 'store'])->name('masterdata.mastersatuan.store');
    Route::put('/master-data/master-satuan/{satuan}', [SatuanController::class, 'update'])->name('masterdata.mastersatuan.update');
    Route::delete('/master-data/master-satuan/{satuan}', [SatuanController::class, 'destroy'])->name('masterdata.mastersatuan.destroy');
    Route::post('/master-data/master-satuan/ajax-store', [SatuanController::class, 'ajaxStore'])->name('masterdata.mastersatuan.ajaxStore');

    Route::get('/master-data/master-rak', [RakController::class, 'index'])->name('masterdata.masterrak');
    Route::post('/master-data/master-rak', [RakController::class, 'store'])->name('masterdata.masterrak.store');
    Route::put('/master-data/master-rak/{rak}', [RakController::class, 'update'])->name('masterdata.masterrak.update');
    Route::delete('/master-data/master-rak/{rak}', [RakController::class, 'destroy'])->name('masterdata.masterrak.destroy');

    Route::get('/master-data/master-gudang', [GudangController::class, 'index'])->name('masterdata.mastergudang');
    Route::post('/master-data/master-gudang', [GudangController::class, 'store'])->name('masterdata.mastergudang.store');
    Route::put('/master-data/master-gudang/{gudang}', [GudangController::class, 'update'])->name('masterdata.mastergudang.update');
    Route::delete('/master-data/master-gudang/{gudang}', [GudangController::class, 'destroy'])->name('masterdata.mastergudang.destroy');

    Route::get('/persediaan/daftar-produk', [DaftarProdukController::class, 'index'])->name('persediaan.daftarproduk');
    Route::post('/persediaan/daftar-produk', [DaftarProdukController::class, 'store'])->name('persediaan.daftarproduk.store');

    Route::get('/persediaan/stok-produk', function (Request $request, FirestoreService $fs) {
        $produks = $fs->all('produks')->sortBy('nama_produk')->values();
        $raks = $fs->all('raks')->sortBy('nama_rak')->values();
        $stokProduks = $fs->all('penyesuaian_stoks')->map(function ($item) use ($fs) {
            $item->produk = $fs->find('produks', $item->produk_id);
            return $item;
        })->filter(function ($item) use ($request) {
            $search=strtolower($request->search ?? '');
            if($search && !str_contains(strtolower(($item->catatan??'').' '.($item->tanggal??'').' '.($item->produk->nama_produk??'').' '.($item->produk->sku??'')), $search)) return false;
            if($request->tanggal_awal && Carbon::parse($item->tanggal)->lt(Carbon::parse($request->tanggal_awal))) return false;
            if($request->tanggal_akhir && Carbon::parse($item->tanggal)->gt(Carbon::parse($request->tanggal_akhir))) return false;
            if($request->status && ($item->produk->status_penjualan??null)!==$request->status) return false;
            if($request->rak && ($item->produk->rak_penyimpanan??null)!==$request->rak) return false;
            return true;
        })->values();
        return view('Persediaan.stokproduk', compact('produks','stokProduks','raks'));
    })->name('persediaan.stokproduk');

    Route::post('/persediaan/stok-produk/simpan', function (Request $request, FirestoreService $fs) {
        $v=$request->validate(['produk_id'=>'required|string','tanggal'=>'required|date','stok_fisik'=>'required|integer|min:0','catatan'=>'nullable|string']);
        $produk=$fs->findOrFail('produks',$v['produk_id']);
        $fs->create('penyesuaian_stoks',$v);
        $fs->update('produks',$produk->id,['stok'=>(int)($produk->stok??0)+(int)$v['stok_fisik']]);
        return redirect()->route('persediaan.stokproduk')->with('success','Penyesuaian stok berhasil disimpan.');
    })->name('persediaan.stokproduk.store');

    Route::delete('/persediaan/stok-produk/{id}', function ($id, FirestoreService $fs) {
        $fs->delete('penyesuaian_stoks',$id); return redirect()->route('persediaan.stokproduk')->with('success','Data berhasil dihapus');
    })->name('persediaan.stokproduk.destroy');

    Route::get('/persediaan/stokopname', function (Request $request, FirestoreService $fs) {
        $mode=$request->get('mode','empty'); $search=strtolower($request->get('search','')); $currentOpname=null; $riwayatOpnames=collect();
        if($mode==='active'){
            $currentOpname=$fs->all('riwayat_opnames')->first(fn($r)=>$r->status==='open');
            if(!$currentOpname) $currentOpname=$fs->create('riwayat_opnames',['kode_opname'=>'SO'.now()->format('ymdHis'),'tanggal_mulai'=>now()->toIso8601String(),'status'=>'open']);
        }
        if($mode==='history'){
            $riwayatOpnames=$fs->all('riwayat_opnames')->where('status','closed')->filter(fn($r)=>!$search || str_contains(strtolower($r->kode_opname??''),$search))->map(function($r)use($fs){ $r->detail_opnames_count=$fs->all('stok_opnames')->where('riwayat_opname_id',$r->id)->count(); return $r; })->values();
        }
        $raks=$fs->all('raks')->sortBy('nama_rak')->values(); $produks=collect();
        if($mode==='active'){
            $opnames=$fs->all('stok_opnames')->where('riwayat_opname_id',$currentOpname->id);
            $produks=$fs->all('produks')->sortBy('nama_produk')->map(function($p)use($opnames){ $p->stokOpname=$opnames->where('produk_id',$p->id)->values(); return $p; })
                ->filter(function($p)use($request,$search){
                    if($search && !str_contains(strtolower(($p->nama_produk??'').' '.($p->sku??'').' '.($p->rak_penyimpanan??'')),$search)) return false;
                    if($request->get('filter_status_produk','semua')!=='semua' && $p->status_penjualan!==$request->get('filter_status_produk')) return false;
                    if($request->get('filter_rak','semua')!=='semua' && $p->rak_penyimpanan!==$request->get('filter_rak')) return false;
                    return true;
                })->values();
        }
        return view('Persediaan.stokopname',compact('produks','mode','raks','currentOpname','riwayatOpnames'));
    })->name('persediaan.stokopname');

    Route::post('/persediaan/stokopname/simpan', function (Request $request, FirestoreService $fs) {
        $v=$request->validate(['produk_id'=>'required|string','stok_fisik'=>'required|integer|min:0','catatan'=>'nullable|string']);
        $current=$fs->all('riwayat_opnames')->first(fn($r)=>$r->status==='open') ?? $fs->create('riwayat_opnames',['kode_opname'=>'SO'.now()->format('ymdHis'),'tanggal_mulai'=>now()->toIso8601String(),'status'=>'open']);
        $produk=$fs->findOrFail('produks',$v['produk_id']); $selisih=(int)$v['stok_fisik']-(int)($produk->stok??0);
        $old=$fs->all('stok_opnames')->first(fn($s)=>$s->produk_id===$v['produk_id'] && $s->riwayat_opname_id===$current->id);
        $data=['produk_id'=>$v['produk_id'],'riwayat_opname_id'=>$current->id,'stok_fisik'=>(int)$v['stok_fisik'],'selisih'=>$selisih,'catatan'=>$v['catatan']??null,'waktu_opname'=>now()->toIso8601String()];
        $old ? $fs->update('stok_opnames',$old->id,$data) : $fs->create('stok_opnames',$data);
        return redirect()->route('persediaan.stokopname',['mode'=>'active'])->with('success','Opname berhasil disimpan.');
    })->name('persediaan.stokopname.store');

    Route::post('/persediaan/stokopname/tutup', function (FirestoreService $fs) {
        $current=$fs->all('riwayat_opnames')->first(fn($r)=>$r->status==='open'); if($current) $fs->update('riwayat_opnames',$current->id,['status'=>'closed','tanggal_selesai'=>now()->toIso8601String()]);
        return redirect()->route('persediaan.stokopname',['mode'=>'history'])->with('success','Opname berhasil ditutup dan masuk ke riwayat.');
    })->name('persediaan.stokopname.tutup');

    Route::prefix('control-user')->name('users.')->group(function () {
        Route::get('/', [UserManagementController::class, 'index'])->name('index');
        Route::get('/create', [UserManagementController::class, 'create'])->name('create');
        Route::post('/', [UserManagementController::class, 'store'])->name('store');
        Route::get('/custom-priv', fn () => view('users.hakakses.custompriv', ['roles'=>collect([(object)['name'=>'admin','is_active'=>true],(object)['name'=>'user','is_active'=>true],(object)['name'=>'kasir','is_active'=>true]])]))->name('custompriv');
        Route::get('/{user}/edit', [UserManagementController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserManagementController::class, 'update'])->name('update');
        Route::patch('/{user}/toggle', [UserManagementController::class, 'toggle'])->name('toggle');
        Route::delete('/{user}', [UserManagementController::class, 'destroy'])->name('destroy');
    });

    Route::get('/penjualan/kasir', fn () => view('Penjualan.kasir', ['penjualan'=>null]))->name('penjualan.kasir');
    Route::get('/penjualan/kasir/search-produk', function (Request $request, FirestoreService $fs) { $q=strtolower(trim($request->get('q',''))); if($q==='') return response()->json([]); return response()->json($fs->all('produks')->filter(fn($p)=>str_contains(strtolower(($p->nama_produk??'').' '.($p->sku??'').' '.($p->barcode??'')),$q))->sortBy('nama_produk')->take(10)->values()); })->name('penjualan.kasir.search');
    Route::post('/penjualan/kasir/store', function (Request $request, FirestoreService $fs) {
        $v=$request->validate(['items'=>'required|array|min:1','items.*.produk_id'=>'required|string','items.*.qty'=>'required|integer|min:1','items.*.satuan'=>'nullable|string','items.*.harga_jual'=>'required|numeric|min:0','items.*.subtotal'=>'required|numeric|min:0','total_penjualan'=>'required|numeric|min:0','status'=>'required|in:selesai,draft','draft_id'=>'nullable|string']);
        if(!empty($v['draft_id'])) $fs->delete('penjualans',$v['draft_id']);
        $prefix=$v['status']==='draft'?'DRF':'SIN'; $penjualan=$fs->create('penjualans',['no_struk'=>$prefix.'-'.now()->format('ymd').'-'.str_pad((string)$fs->nextNumber('penjualans'),3,'0',STR_PAD_LEFT),'tanggal'=>now()->toIso8601String(),'pelanggan'=>null,'total_penjualan'=>(float)$v['total_penjualan'],'status'=>$v['status']]);
        foreach($v['items'] as $item){ $fs->create('detail_penjualans',['penjualan_id'=>$penjualan->id,'produk_id'=>$item['produk_id'],'qty'=>(int)$item['qty'],'satuan'=>$item['satuan']??null,'harga_jual'=>(float)$item['harga_jual'],'subtotal'=>(float)$item['subtotal']]); }
        return response()->json(['success'=>true,'message'=>$v['status']==='draft'?'Transaksi berhasil ditunda':'Transaksi berhasil dibuat','penjualan_id'=>$penjualan->id]);
    })->name('penjualan.kasir.store');

    $attachDetails = function ($penjualan, FirestoreService $fs) { $penjualan->details=$fs->all('detail_penjualans')->where('penjualan_id',$penjualan->id)->map(function($d)use($fs){ $d->produk=$fs->find('produks',$d->produk_id); return $d; })->values(); return $penjualan; };
    Route::get('/penjualan/daftar-penjualan', function (Request $request, FirestoreService $fs) use ($attachDetails) { $items=$fs->all('penjualans')->where('status','!=','draft')->map(fn($p)=>$attachDetails($p,$fs))->filter(function($p)use($request){ if($request->status_transaksi && $request->status_transaksi!=='semua' && $p->status!==$request->status_transaksi) return false; if($request->tanggal_awal && Carbon::parse($p->tanggal)->lt(Carbon::parse($request->tanggal_awal))) return false; if($request->tanggal_akhir && Carbon::parse($p->tanggal)->gt(Carbon::parse($request->tanggal_akhir))) return false; if($request->search && !str_contains(strtolower(($p->no_struk??'').' '.$p->details->map(fn($d)=>$d->produk->nama_produk??'')->implode(' ')),strtolower($request->search))) return false; return true; })->values(); return view('Penjualan.daftarpenjualan',['penjualans'=>$items]); })->name('penjualan.daftarpenjualan');
    Route::get('/penjualan/detail/{id}', fn ($id, FirestoreService $fs) => response()->json($attachDetails($fs->findOrFail('penjualans',$id),$fs)))->name('penjualan.detail');
    Route::get('/penjualan/export-excel', function (FirestoreService $fs) use ($attachDetails) { $header=collect([['PENJUALAN','','',''],['--------------------------------','','',''],['Nama Outlet',': Apotek Assalam','',''],['ID Outlet',': aptassalambekasi','',''],['Dari Tanggal',': '.now()->format('d M Y'),'',''],['Sampai Tanggal',': '.now()->format('d M Y'),'',''],['Di-export Pada Tanggal',': '.now()->format('d M Y \p\u\k\u\l H.i'),'',''],['--------------------------------','','',''],['','','',''],['Tanggal','No Struk','Produk','Total Penjualan']]); $data=$fs->all('penjualans')->where('status','!=','draft')->map(fn($p)=>$attachDetails($p,$fs))->map(fn($p)=>[Carbon::parse($p->tanggal)->format('d/m/Y'),$p->no_struk,$p->details->map(fn($d)=>$d->qty.' x '.($d->produk->nama_produk??'-'))->implode(', '),'Rp '.number_format($p->total_penjualan,2,',','.')]); return (new FastExcel($header->merge($data)))->download('daftar_penjualan.xlsx'); })->name('penjualan.export.excel');
    Route::get('/penjualan/tertunda', function (Request $request, FirestoreService $fs) use ($attachDetails) { $items=$fs->all('penjualans')->where('status','draft')->map(fn($p)=>$attachDetails($p,$fs))->filter(fn($p)=>!$request->search || str_contains(strtolower($p->no_struk??''),strtolower($request->search)))->values(); return view('Penjualan.penjualantertunda',['penjualans'=>$items]); })->name('penjualan.tertunda');
    Route::get('/penjualan/kasir/{id}/lanjutkan', fn ($id, FirestoreService $fs) => view('Penjualan.kasir',['penjualan'=>$attachDetails($fs->findOrFail('penjualans',$id),$fs)]))->name('penjualan.kasir.lanjutkan');
    Route::delete('/penjualan/tertunda/{id}', function ($id, FirestoreService $fs){ $fs->delete('penjualans',$id); return redirect()->route('penjualan.tertunda')->with('success','Draft berhasil dihapus'); })->name('penjualan.tertunda.destroy');

    Route::get('/persediaan/gudang-penyimpanan', function (Request $request, FirestoreService $fs) { $gudangs=$fs->all('gudangs')->sortBy('nama_gudang')->values(); $selectedGudangId=$request->get('gudang_id'); $selectedGudang=$selectedGudangId?$fs->find('gudangs',$selectedGudangId):null; $produks=$fs->all('produks')->sortBy('nama_produk')->values(); $produkGudang=collect(); if($selectedGudang){ $produkGudang=$fs->all('gudang_produks')->where('gudang_id',$selectedGudangId)->map(function($i)use($fs){$i->produk=$fs->find('produks',$i->produk_id); return $i;})->values(); } return view('Persediaan.gudangpenyimpanan',compact('gudangs','selectedGudang','selectedGudangId','produkGudang','produks')); })->name('persediaan.gudangpenyimpanan');
    Route::post('/persediaan/gudang-penyimpanan/store', function (Request $request, FirestoreService $fs) { $v=$request->validate(['gudang_id'=>'required|string','produk_id'=>'required|string','stok'=>'nullable|integer|min:0']); $old=$fs->all('gudang_produks')->first(fn($i)=>$i->gudang_id===$v['gudang_id'] && $i->produk_id===$v['produk_id']); $data=['gudang_id'=>$v['gudang_id'],'produk_id'=>$v['produk_id'],'stok'=>(int)($v['stok']??0)]; $old?$fs->update('gudang_produks',$old->id,$data):$fs->create('gudang_produks',$data); return redirect()->route('persediaan.gudangpenyimpanan',['gudang_id'=>$v['gudang_id']])->with('success','Produk berhasil dimasukkan ke gudang.'); })->name('persediaan.gudangpenyimpanan.store');
    Route::delete('/persediaan/gudang-penyimpanan/{id}', function ($id, FirestoreService $fs) { $item=$fs->findOrFail('gudang_produks',$id); $gudangId=$item->gudang_id; $fs->delete('gudang_produks',$id); return redirect()->route('persediaan.gudangpenyimpanan',['gudang_id'=>$gudangId])->with('success','Produk berhasil dihapus dari gudang.'); })->name('persediaan.gudangpenyimpanan.destroy');

    Route::get('/penjualan/qris', fn () => view('Penjualan.qris'))->name('penjualan.qris');
    Route::get('/pusat-bantuan/usulkan-fitur-baru', fn () => view('PusatBantuan.fiturbaru'))->name('pusatbantuan.fiturbaru');
    Route::get('/pusat-bantuan/riwayat-update', fn () => view('PusatBantuan.riwayatupdate'))->name('pusatbantuan.riwayatupdate');
    Route::get('/pusat-bantuan/minta-bantuan', fn () => view('PusatBantuan.mintabantuan'))->name('pusatbantuan.mintabantuan');
    Route::post('/pusat-bantuan/usulkan-fitur-baru', function (Request $request) { $v=$request->validate(['nama_fitur'=>'required|string|max:255','kategori'=>'required|string|max:100','deskripsi'=>'required|string','manfaat'=>'required|string']); Mail::to('refree06@gmail.com')->send(new UsulanFiturMail($v)); return redirect()->route('pusatbantuan.fiturbaru')->with('success','Usulan fitur berhasil dikirim ke email.'); })->name('pusatbantuan.fiturbaru.store');
    Route::post('/pusat-bantuan/minta-bantuan', function (Request $request) { $v=$request->validate(['subjek'=>'required|string|max:255','kategori'=>'required|string|max:100','detail'=>'required|string']); Mail::to('refree06@gmail.com')->send(new MintaBantuanMail($v)); $pesanWa="Halo Admin Apotek Saya,\n\nSaya ingin melaporkan kendala:\n\nSubjek: {$v['subjek']}\nKategori: {$v['kategori']}\nDetail: {$v['detail']}"; return redirect()->route('pusatbantuan.mintabantuan')->with('success','Laporan berhasil dikirim ke email.')->with('wa_link','https://wa.me/6281398357731?text='.urlencode($pesanWa)); })->name('pusatbantuan.mintabantuan.store');
    Route::get('/settings', fn () => view('Settings.index'))->name('settings.index');
    Route::post('/settings/notifications', fn (Request $request) => redirect()->route('settings.index')->with('success',$request->has('notifications_enabled')?'Notifikasi berhasil diaktifkan.':'Notifikasi berhasil dimatikan.'))->name('settings.notifications.update');
    Route::get('/help-center', fn () => view('HelpCenter.index'))->name('helpcenter.index');
});
