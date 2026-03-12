<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::latest()->get();

        return view('masterdata.mastergudang', compact('gudangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gudang' => 'required|string|max:255|unique:gudangs,nama_gudang',
        ]);

        Gudang::create([
            'nama_gudang' => $validated['nama_gudang'],
            'status' => 'aktif',
        ]);

        return redirect()
            ->route('masterdata.mastergudang')
            ->with('success', 'Gudang berhasil ditambahkan.');
    }

    public function update(Request $request, Gudang $gudang)
    {
        $validated = $request->validate([
            'nama_gudang' => 'required|string|max:255|unique:gudangs,nama_gudang,' . $gudang->id,
        ]);

        $gudang->update([
            'nama_gudang' => $validated['nama_gudang'],
        ]);

        return redirect()
            ->route('masterdata.mastergudang')
            ->with('success', 'Gudang berhasil diperbarui.');
    }

    public function destroy(Gudang $gudang)
    {
        $gudang->delete();

        return redirect()
            ->route('masterdata.mastergudang')
            ->with('success', 'Gudang berhasil dihapus.');
    }
}