<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kepemilikan;
use App\Models\Jenis;
use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AsetController extends Controller
{
    public function index()
    {

        $aset = Aset::with(['kepemilikan', 'kegiatan'])->paginate(10);

        $kepemilikan = Kepemilikan::active()->get();
        $jenis = Jenis::active()->get();
        $kegiatan = Kegiatan::all();

        return view('aset.index', compact('aset', 'kepemilikan', 'jenis', 'kegiatan'));
    }


    public function detail(string $uuid)
    {
        $aset = Aset::select([
            'id',
            'nama_barang',
            'id_master_jenis',
            'nomor_aset',
            'serial_number',
            'part_number',
            'spek',
            'lokasi',
            'foto_aset',
            'pengguna',
            'status',
            'tahun_kepemilikan',
            'id_kepemilikan',
            'created_at',
        ])
            ->with(['kegiatan' => function ($query) {
                $query->select('id', 'id_aset', 'id_master_kegiatan', 'id_user', 'note', 'foto', 'created_at')
                    ->with([
                        'masterKegiatan:id,kegiatan,is_custom',
                        'user:id,name'
                    ])
                    ->latest()
                    ->take(10);
            }, 'jenis:id,jenis', 'kepemilikan:id,kepemilikan'])
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
            'id_master_jenis' => 'nullable',
            'nomor_aset' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'spek' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'foto_aset' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pengguna' => 'nullable|string|max:255',
            'tahun_kepemilikan' => 'nullable|integer|digits:4',
            'status' => 'nullable',
            'id_kepemilikan' => 'nullable',
        ]);

        $fotoPath = null;

        if ($request->hasFile('foto_aset')) {
            $file = $request->file('foto_aset');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $storagePath = 'aset/' . $fileName;

            $image = $this->compressImage($file);

            Storage::disk('public')->put($storagePath, $image);

            $validated['foto_aset'] = $storagePath;
        }

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

        $aset = Aset::select([
            'id',
            'nama_barang',
            'id_master_jenis',
            'nomor_aset',
            'serial_number',
            'part_number',
            'spek',
            'lokasi',
            'foto_aset',
            'status',
            'pengguna',
            'tahun_kepemilikan',
            'id_kepemilikan'
        ])->findOrFail($uuid);

        $kepemilikan = Kepemilikan::active()->select('id', 'kepemilikan')->get();
        $jenis = Jenis::active()->get();

        if (request()->ajax()) {
            return response()->json([
                'html' => view('aset._edit', compact('aset', 'kepemilikan', 'jenis'))->render()
            ]);
        }

        return view('aset._edit', compact('aset', 'kepemilikan', 'jenis'));
    }

    public function update(Request $request, string $uuid)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'id_master_jenis' => 'required|exists:jenis,id',
            'nomor_aset' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'part_number' => 'nullable|string|max:255',
            'spek' => 'nullable|string',
            'lokasi' => 'nullable|string',
            'foto_aset' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pengguna' => 'required|string|max:255',
            'status' => 'required',
            'tahun_kepemilikan' => 'nullable|integer|digits:4',
            'id_kepemilikan' => 'required|exists:kepemilikans,id',
        ]);

        $aset = Aset::findOrFail($uuid);

        if ($request->hasFile('foto_aset')) {
            $file = $request->file('foto_aset');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $storagePath = 'aset/' . $fileName;

            if ($aset->foto_aset && Storage::disk('public')->exists($aset->foto_aset)) {
                Storage::disk('public')->delete($aset->foto_aset);
            }

            $image = $this->compressImage($file);

            Storage::disk('public')->put($storagePath, $image);

            $validated['foto_aset'] = $storagePath;
        }

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

    private function compressImage($file)
    {
        $image = imagecreatefromstring(file_get_contents($file->getRealPath()));

        $width = imagesx($image);
        $heigth = imagesy($image);

        $newWidth = min($width, 1920);
        $newHeigth = floor($heigth * ($newWidth / $width));

        $newImage = imagecreatetruecolor($newWidth, $newHeigth);

        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeigth, $width, $heigth);

        ob_start();
        imagejpeg($newImage, null, 75);
        $comppresedImage = ob_get_clean();

        imagedestroy($image);
        imagedestroy($newImage);

        return $comppresedImage;
    }

    public function printSelected(Request $request)
    {
        $asetIds = $request->input('selected_asets', []);
        $asets = Aset::whereIn('id', $asetIds)->get();

        return view('aset.print-qrcodes', compact('asets'));
    }
}
