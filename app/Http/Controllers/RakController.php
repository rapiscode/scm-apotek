<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class RakController extends Controller
{
    public function __construct(protected FirestoreService $firestore) {}
    public function index(){ $raks=$this->firestore->all('raks'); return view('masterdata.masterrak',compact('raks')); }
    public function store(Request $request){ $v=$request->validate(['nama_rak'=>'required|string|max:255']); if(!$this->firestore->unique('raks','nama_rak',$v['nama_rak'])) throw ValidationException::withMessages(['nama_rak'=>'Nama rak sudah ada.']); $this->firestore->create('raks',['nama_rak'=>$v['nama_rak'],'status'=>'aktif']); return redirect()->route('masterdata.masterrak')->with('success','Rak berhasil ditambahkan.'); }
    public function update(Request $request,string $rak){ $v=$request->validate(['nama_rak'=>'required|string|max:255']); if(!$this->firestore->unique('raks','nama_rak',$v['nama_rak'],$rak)) throw ValidationException::withMessages(['nama_rak'=>'Nama rak sudah ada.']); $this->firestore->update('raks',$rak,['nama_rak'=>$v['nama_rak']]); return redirect()->route('masterdata.masterrak')->with('success','Rak berhasil diperbarui.'); }
    public function destroy(string $rak){ $this->firestore->delete('raks',$rak); return redirect()->route('masterdata.masterrak')->with('success','Rak berhasil dihapus.'); }
}
