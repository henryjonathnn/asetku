<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kepemilikan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aset = Aset::paginate(10); // Adjust the number of items per page as needed
        $kepemilikan = Kepemilikan::all();

        return view('aset.index', compact('aset', 'kepemilikan'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'nullable|string|max:255',
            'jenis' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'spek' => 'nullable|string',
            'pengguna' => 'nullable|string|max:255',
            'tahun_kepemilikan' => 'nullable|integer|digits:4',
            'id_kepemilikan' => 'nullable',
        ]);

        $aset = Aset::create($validated);

        return redirect()->route('aset.index')
            ->with('success', 'Data aset berhasil ditambahkan!')
            ->with('generated_uuid', $aset->id);
    }

    public function detail(string $uuid)
    {
        $aset = Aset::with(['kegiatan' => function ($query) {
            $query->with(['masterKegiatan', 'user'])
                ->latest();
        }])->findOrFail($uuid);
        return view('aset._show', compact('aset'));
    }

    public function edit($uuid)
    {
        $aset = Aset::findOrFail($uuid);
        $kepemilikan = Kepemilikan::all();
        return view('aset._edit', compact('aset', 'kepemilikan'));
    }

    public function update(Request $request, string $uuid)
    {

        $aset = Aset::findOrFail($uuid);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'spek' => 'nullable|string',
            'pengguna' => 'required|string|max:255',
            'tahun_kepemilikan' => 'nullable|integer|digits:4',
            'id_kepemilikan' => 'required|exists:kepemilikans,id',
        ]);

        $aset->update($validated);

        return redirect()->route('aset.index')
            ->with('success', 'Data aset berhasil diperbarui!');
    }
}
