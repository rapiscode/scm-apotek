<?php

namespace App\Http\Controllers;

use App\Services\FirestoreService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SatuanController extends Controller
{
    public function __construct(protected FirestoreService $firestore) {}

    public function index(){ $satuans = $this->firestore->all('satuans'); return view('masterdata.mastersatuan', compact('satuans')); }

    public function store(Request $request)
    {
        $validated = $request->validate(['nama_satuan'=>'required|string|max:255']);
        if (! $this->firestore->unique('satuans','nama_satuan',$validated['nama_satuan'])) throw ValidationException::withMessages(['nama_satuan'=>'Nama satuan sudah ada.']);
        $this->firestore->create('satuans', ['nama_satuan'=>$validated['nama_satuan'], 'status'=>'aktif']);
        return redirect()->route('masterdata.mastersatuan')->with('success','Satuan berhasil ditambahkan.');
    }

    public function update(Request $request, string $satuan)
    {
        $validated = $request->validate(['nama_satuan'=>'required|string|max:255']);
        if (! $this->firestore->unique('satuans','nama_satuan',$validated['nama_satuan'],$satuan)) throw ValidationException::withMessages(['nama_satuan'=>'Nama satuan sudah ada.']);
        $this->firestore->update('satuans', $satuan, ['nama_satuan'=>$validated['nama_satuan']]);
        return redirect()->route('masterdata.mastersatuan')->with('success','Satuan berhasil diperbarui.');
    }

    public function destroy(string $satuan)
    { $this->firestore->delete('satuans',$satuan); return redirect()->route('masterdata.mastersatuan')->with('success','Satuan berhasil dihapus.'); }

    public function ajaxStore(Request $request)
    {
        $validated = $request->validate(['nama_satuan'=>'required|string|max:255']);
        if (! $this->firestore->unique('satuans','nama_satuan',$validated['nama_satuan'])) return response()->json(['success'=>false,'message'=>'Nama satuan sudah ada.'],422);
        $satuan = $this->firestore->create('satuans', ['nama_satuan'=>$validated['nama_satuan'], 'status'=>'aktif']);
        return response()->json(['success'=>true,'message'=>'Satuan berhasil ditambahkan.','data'=>['id'=>$satuan->id,'nama_satuan'=>$satuan->nama_satuan]]);
    }
}
