<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kepemilikan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AsetController extends Controller
{
    public function index()
    {
        // Tetap menggunakan all() untuk kemudahan development
        $aset = Aset::with('kepemilikan')->paginate(10);
        $kepemilikan = Kepemilikan::all();

        return view('aset.index', compact('aset', 'kepemilikan'));
    }

    // Optimasi khusus untuk modal/detail view
    public function detail(string $uuid)
    {
        $aset = Aset::select([
            'id',
            'nama_barang',
            'jenis',
            'serial_number',
            'part_number',
            'spek',
            'pengguna',
            'tahun_kepemilikan',
            'id_kepemilikan',
            'created_at',
        ])
            ->with(['kegiatan' => function ($query) {
                $query->select('id', 'id_aset', 'id_master_kegiatan', 'id_user', 'created_at')
                    ->with([
                        'masterKegiatan:id,kegiatan',
                        'user:id,name'
                    ])
                    ->latest()
                    ->take(10);
            }])
            ->findOrFail($uuid);

        if (request()->ajax()) {
            return response()->json([
                'html' => view('aset._show', compact('aset'))->render()
            ]);
        }

        return view('aset._show', compact('aset'));
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

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data aset berhasil ditambahkan!',
                'id' => $aset->id
            ]);
        }

        return redirect()->route('aset.index')
            ->with('success', 'Data aset berhasil ditambahkan!')
            ->with('generated_uuid', $aset->id);
    }

    public function edit($uuid)
    {
        // Optimasi untuk modal edit
        $aset = Aset::select([
            'id',
            'nama_barang',
            'jenis',
            'serial_number',
            'part_number',
            'spek',
            'pengguna',
            'tahun_kepemilikan',
            'id_kepemilikan'
        ])->findOrFail($uuid);

        $kepemilikan = Kepemilikan::select('id', 'kepemilikan')->get();

        if (request()->ajax()) {
            return response()->json([
                'html' => view('aset._edit', compact('aset', 'kepemilikan'))->render()
            ]);
        }

        return view('aset._edit', compact('aset', 'kepemilikan'));
    }

    public function update(Request $request, string $uuid)
    {
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

        $aset = Aset::findOrFail($uuid);
        $aset->update($validated);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data aset berhasil diperbarui!'
            ]);
        }

        return redirect()->route('aset.index')
            ->with('success', 'Data aset berhasil diperbarui!');
    }

    public function printSelected(Request $request)
    {
        $asetIds = $request->input('selected_asets', []);
        $asets = Aset::whereIn('id', $asetIds)->get();

        return view('aset.print-qrcodes', compact('asets'));
    }
}
