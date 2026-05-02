<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GudangController extends Controller
{
    public function __construct(protected FirestoreService $firestore) {}
    public function index(){ $gudangs=$this->firestore->all('gudangs'); return view('masterdata.mastergudang',compact('gudangs')); }
    public function store(Request $request){ $v=$request->validate(['nama_gudang'=>'required|string|max:255']); if(!$this->firestore->unique('gudangs','nama_gudang',$v['nama_gudang'])) throw ValidationException::withMessages(['nama_gudang'=>'Nama gudang sudah ada.']); $this->firestore->create('gudangs',['nama_gudang'=>$v['nama_gudang'],'status'=>'aktif']); return redirect()->route('masterdata.mastergudang')->with('success','Gudang berhasil ditambahkan.'); }
    public function update(Request $request,string $gudang){ $v=$request->validate(['nama_gudang'=>'required|string|max:255']); if(!$this->firestore->unique('gudangs','nama_gudang',$v['nama_gudang'],$gudang)) throw ValidationException::withMessages(['nama_gudang'=>'Nama gudang sudah ada.']); $this->firestore->update('gudangs',$gudang,['nama_gudang'=>$v['nama_gudang']]); return redirect()->route('masterdata.mastergudang')->with('success','Gudang berhasil diperbarui.'); }
    public function destroy(string $gudang){ $this->firestore->delete('gudangs',$gudang); return redirect()->route('masterdata.mastergudang')->with('success','Gudang berhasil dihapus.'); }
}
