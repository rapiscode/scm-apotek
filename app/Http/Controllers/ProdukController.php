<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Rap2hpoutre\FastExcel\FastExcel;

class ProdukController extends Controller
{
    public function __construct(protected FirestoreService $firestore) {}

    protected function payload(array $v): array
    {
        return [
            'tipe_produk'=>$v['tipe_produk'], 'nama_produk'=>$v['nama_produk'], 'nama_pabrik'=>$v['nama_pabrik']??null,
            'sku'=>$v['sku'], 'barcode'=>$v['barcode']??null, 'pajak'=>$v['pajak']??null, 'satuan_utama'=>$v['satuan_utama'],
            'harga_beli'=>(float)($v['harga_beli']??0), 'harga_jual'=>(float)($v['harga_jual']??0), 'stok'=>(int)($v['stok']??0),
            'stok_minimal'=>(int)($v['stok_minimal']??0), 'stok_maksimal'=>(int)($v['stok_maksimal']??0),
            'rak_penyimpanan'=>$v['rak_penyimpanan']??null, 'status_penjualan'=>$v['status_penjualan'], 'catatan'=>$v['catatan']??null,
        ];
    }

    protected function rules(): array
    {
        return [
            'tipe_produk'=>'required|string|max:50','nama_produk'=>'required|string|max:255','nama_pabrik'=>'nullable|string|max:255',
            'sku'=>'required|string|max:255','barcode'=>'nullable|string|max:255','pajak'=>'nullable|string|max:50','satuan_utama'=>'required|string|max:100',
            'harga_beli'=>'nullable|numeric|min:0','harga_jual'=>'nullable|numeric|min:0','stok'=>'nullable|integer|min:0',
            'stok_minimal'=>'nullable|integer|min:0','stok_maksimal'=>'nullable|integer|min:0','rak_penyimpanan'=>'nullable|string|max:255',
            'status_penjualan'=>'required|string|in:dijual,tidak_dijual','catatan'=>'nullable|string',
        ];
    }

    public function index()
    {
        $produks = $this->firestore->all('produks');
        $produkStats = (object)['dijual'=>$produks->where('status_penjualan','dijual')->count(), 'tidak_dijual'=>$produks->where('status_penjualan','tidak_dijual')->count()];
        $satuans = $this->firestore->all('satuans')->where('status','aktif')->sortBy('nama_satuan')->values();
        $raks = $this->firestore->all('raks')->where('status','aktif')->sortBy('nama_rak')->values();
        return view('masterdata.produk.masterproduk', compact('produks','produkStats','satuans','raks'));
    }

    public function store(Request $request)
    {
        $v=$request->validate($this->rules());
        if(!$this->firestore->unique('produks','sku',$v['sku'])) throw ValidationException::withMessages(['sku'=>'SKU sudah dipakai.']);
        $this->firestore->create('produks',$this->payload($v));
        return redirect()->route('masterdata.masterproduk')->with('success','Produk berhasil ditambahkan.');
    }

    public function update(Request $request, string $produk)
    {
        $v=$request->validate($this->rules());
        if(!$this->firestore->unique('produks','sku',$v['sku'],$produk)) throw ValidationException::withMessages(['sku'=>'SKU sudah dipakai.']);
        $this->firestore->update('produks',$produk,$this->payload($v));
        return redirect()->route('masterdata.masterproduk')->with('success','Produk berhasil diperbarui.');
    }

    public function destroy(string $produk)
    { $this->firestore->delete('produks',$produk); return redirect()->route('masterdata.masterproduk')->with('success','Produk berhasil dihapus.'); }

    public function downloadTemplate(){ $path=storage_path('app/public/templates/template_import_produk.xlsx'); if(!file_exists($path)) abort(404,'File template tidak ditemukan.'); return response()->download($path,'template_import_produk.xlsx'); }

    public function import(Request $request)
    {
        $request->validate(['file_import'=>'required|file|mimes:xlsx,xls|max:5120']);
        $path=$request->file('file_import')->storeAs('temp',time().'_'.$request->file('file_import')->getClientOriginalName(),'local');
        $fullPath=Storage::disk('local')->path($path); $rowNumber=0;
        (new FastExcel)->startRow(1)->sheet(2)->import($fullPath,function($row) use (&$rowNumber){
            $rowNumber++; if($rowNumber===1 || empty($row['sku *']??null) || empty($row['nama_produk *']??null)) return null;
            if(!$this->firestore->unique('produks','sku',$row['sku *'])) return null;
            return $this->firestore->create('produks',$this->payload([
                'tipe_produk'=>$row['tipe_produk *']??'umum','nama_produk'=>$row['nama_produk *']??null,'nama_pabrik'=>$row['nama_pabrik']??null,
                'sku'=>$row['sku *']??null,'barcode'=>$row['barcode']??null,'pajak'=>$row['pajak']??null,'satuan_utama'=>$row['satuan_utama *']??'-',
                'harga_beli'=>$row['harga_beli']??0,'harga_jual'=>$row['harga_jual']??0,'stok'=>$row['stok']??0,'stok_minimal'=>$row['stok_minimal']??0,
                'stok_maksimal'=>$row['stok_maksimal']??0,'rak_penyimpanan'=>$row['rak_penyimpanan']??null,'status_penjualan'=>$row['status_penjualan *']??'dijual','catatan'=>$row['catatan']??null,
            ]));
        });
        Storage::disk('local')->delete($path); return redirect()->route('masterdata.masterproduk')->with('success','Produk berhasil diimport.');
    }

    public function exportEditTemplate()
    {
        $produks=$this->firestore->all('produks')->map(fn($p)=>$p->toArray());
        $filePath=storage_path('app/temp/edit_produk_'.now()->format('Ymd_His').'.xlsx'); if(!file_exists(dirname($filePath))) mkdir(dirname($filePath),0777,true);
        (new FastExcel($produks))->export($filePath); return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function importUpdate(Request $request)
    {
        $request->validate(['file_edit_produk'=>'required|file|mimes:xlsx,xls|max:5120']);
        (new FastExcel)->import($request->file('file_edit_produk')->getRealPath(),function($row){
            $produk = !empty($row['id']??null) ? $this->firestore->find('produks',$row['id']) : null;
            if(!$produk && !empty($row['sku']??null)) $produk=$this->firestore->firstWhere('produks','sku',$row['sku']);
            if(!$produk) return null;
            $data=$produk->toArray(); foreach($row as $k=>$v){ if($v!==null && $v!=='') $data[$k]=$v; }
            $this->firestore->update('produks',$produk->id,$data); return null;
        });
        return redirect()->route('masterdata.masterproduk')->with('success','Produk berhasil diperbarui secara massal.');
    }

    public function downloadAllProduk()
    {
        $data=$this->firestore->all('produks')->map(fn($p)=>[
            'ID'=>$p->id,'Tipe Produk'=>$p->tipe_produk,'Nama Produk'=>$p->nama_produk,'Nama Pabrik'=>$p->nama_pabrik,'SKU'=>$p->sku,
            'Barcode'=>$p->barcode,'Pajak'=>$p->pajak,'Satuan Utama'=>$p->satuan_utama,'Harga Beli'=>$p->harga_beli,'Harga Jual'=>$p->harga_jual,
            'Stok Minimal'=>$p->stok_minimal,'Stok Maksimal'=>$p->stok_maksimal,'Rak Penyimpanan'=>$p->rak_penyimpanan,'Status Penjualan'=>$p->status_penjualan,'Catatan'=>$p->catatan,
            'Dibuat Pada'=>$p->created_at,'Diubah Pada'=>$p->updated_at,
        ]);
        $filePath=storage_path('app/temp/master_produk_'.now()->format('Ymd_His').'.xlsx'); if(!file_exists(dirname($filePath))) mkdir(dirname($filePath),0777,true);
        (new FastExcel($data))->export($filePath); return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
