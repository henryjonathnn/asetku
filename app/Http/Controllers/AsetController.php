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
        $aset = Aset::with(['kepemilikan', 'kegiatan'])->latest()->get()->paginate(50);
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
            'tahun_kepemilikan' => 'nullable|integer|digits:4',
            'id_kepemilikan' => 'nullable',
        ]);

        $aset = Aset::create($validated);

        return redirect()->route('aset.index')
            ->with('success', 'Data aset berhasil ditambahkan!')
            ->with('generated_uuid', $aset->id);
    }

    public function show(string $uuid)
    {
        $aset = Aset::with(['kepemilikan', 'kegiatan.user'])->findOrFail($uuid);
        return view('aset.show', compact('aset'));
    }

    public function update(Request $request, string $uuid)
    {
        $this->validateUser($request);

        $aset = Aset::findOrFail($uuid);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'spek' => 'nullable|string',
            'tahun_kepemilikan' => 'nullable|integer|digits:4',
            'id_kepemilikan' => 'required|exists:kepemilikans,id',
        ]);

        $aset->update($validated);

        return redirect()->route('aset.index')
            ->with('success', 'Data aset berhasil diperbarui!');
    }

    public function validateUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password tidak valid.'],
            ]);
        }
        return true;
    }
}
