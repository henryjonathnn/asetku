<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kepemilikan;
use Illuminate\Http\Request;

class AsetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aset = Aset::with('kepemilikan')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('aset.index', compact('aset'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kepemilikan = Kepemilikan::all();
        return view('aset.create', compact('kepemilikan'));
    }

    /**
     * Store a newly created resource in storage.
     */
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

        return redirect()->route('aset.index')->with('success', 'Data aset berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'spek' => 'nullable|string',
            'tahun_kepemilikan' => 'nullable|integer|digits:4',
            'id_kepemilikan' => 'required|exists:kepemilikans,id',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
}
