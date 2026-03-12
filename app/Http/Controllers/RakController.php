<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        $raks = Rak::latest()->get();

        return view('masterdata.masterrak', compact('raks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_rak' => 'required|string|max:255|unique:raks,nama_rak',
        ]);

        Rak::create([
            'nama_rak' => $validated['nama_rak'],
            'status' => 'aktif',
        ]);

        return redirect()
            ->route('masterdata.masterrak')
            ->with('success', 'Rak berhasil ditambahkan.');
    }

    public function update(Request $request, Rak $rak)
    {
        $validated = $request->validate([
            'nama_rak' => 'required|string|max:255|unique:raks,nama_rak,' . $rak->id,
        ]);

        $rak->update([
            'nama_rak' => $validated['nama_rak'],
        ]);

        return redirect()
            ->route('masterdata.masterrak')
            ->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Rak $rak)
    {
        $rak->delete();

        return redirect()
            ->route('masterdata.masterrak')
            ->with('success', 'Rak berhasil dihapus.');
    }
}