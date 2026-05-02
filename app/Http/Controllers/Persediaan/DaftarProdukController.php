<?php

namespace App\Http\Controllers\Persediaan;

use App\Http\Controllers\Controller;
use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DaftarProdukController extends Controller
{
    public function __construct(protected FirestoreService $firestore) {}
    protected function rules(): array { return ['tipe_produk'=>'required|string|max:50','nama_produk'=>'required|string|max:255','nama_pabrik'=>'nullable|string|max:255','sku'=>'required|string|max:255','barcode'=>'nullable|string|max:255','pajak'=>'nullable|string|max:50','satuan_utama'=>'required|string|max:100','harga_beli'=>'nullable|numeric|min:0','harga_jual'=>'nullable|numeric|min:0','stok_minimal'=>'nullable|integer|min:0','stok_maksimal'=>'nullable|integer|min:0','rak_penyimpanan'=>'nullable|string|max:255','status_penjualan'=>'required|string|in:dijual,tidak_dijual','catatan'=>'nullable|string']; }
    public function index(){ $produks=$this->firestore->all('produks'); $satuans=$this->firestore->all('satuans')->where('status','aktif')->sortBy('nama_satuan')->values(); $raks=$this->firestore->all('raks')->where('status','aktif')->sortBy('nama_rak')->values(); return view('Persediaan.daftarproduk',compact('produks','satuans','raks')); }
    public function store(Request $request){ $v=$request->validate($this->rules()); if(!$this->firestore->unique('produks','sku',$v['sku'])) throw ValidationException::withMessages(['sku'=>'SKU sudah dipakai.']); $this->firestore->create('produks',['tipe_produk'=>$v['tipe_produk'],'nama_produk'=>$v['nama_produk'],'nama_pabrik'=>$v['nama_pabrik']??null,'sku'=>$v['sku'],'barcode'=>$v['barcode']??null,'pajak'=>$v['pajak']??null,'satuan_utama'=>$v['satuan_utama'],'harga_beli'=>(float)($v['harga_beli']??0),'harga_jual'=>(float)($v['harga_jual']??0),'stok'=>(int)($v['stok']??0),'stok_minimal'=>(int)($v['stok_minimal']??0),'stok_maksimal'=>(int)($v['stok_maksimal']??0),'rak_penyimpanan'=>$v['rak_penyimpanan']??null,'status_penjualan'=>$v['status_penjualan'],'catatan'=>$v['catatan']??null]); return redirect()->route('persediaan.daftarproduk')->with('success','Produk berhasil ditambahkan.'); }
}
