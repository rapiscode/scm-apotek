<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = Satuan::latest()->get();

        return view('masterdata.mastersatuan', compact('satuans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuans,nama_satuan',
        ]);

        Satuan::create([
            'nama_satuan' => $validated['nama_satuan'],
            'status' => 'aktif',
        ]);

        return redirect()
            ->route('masterdata.mastersatuan')
            ->with('success', 'Satuan berhasil ditambahkan.');
    }

    public function update(Request $request, Satuan $satuan)
    {
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuans,nama_satuan,' . $satuan->id,
        ]);

        $satuan->update([
            'nama_satuan' => $validated['nama_satuan'],
        ]);

        return redirect()
            ->route('masterdata.mastersatuan')
            ->with('success', 'Satuan berhasil diperbarui.');
    }

    public function destroy(Satuan $satuan)
    {
        $satuan->delete();

        return redirect()
            ->route('masterdata.mastersatuan')
            ->with('success', 'Satuan berhasil dihapus.');
    }

    public function ajaxStore(Request $request)
    {
        $validated = $request->validate([
            'nama_satuan' => 'required|string|max:255|unique:satuans,nama_satuan',
        ]);

        $satuan = Satuan::create([
            'nama_satuan' => $validated['nama_satuan'],
            'status' => 'aktif',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Satuan berhasil ditambahkan.',
            'data' => [
                'id' => $satuan->id,
                'nama_satuan' => $satuan->nama_satuan,
            ]
        ]);
    }
}