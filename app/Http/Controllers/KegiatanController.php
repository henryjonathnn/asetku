<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kegiatan;
use App\Models\Kepemilikan;
use App\Models\Jenis;
use App\Models\MasterKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($uuid)
    {
        $aset = Aset::findOrFail($uuid);
        $kegiatan = Kegiatan::with(['masterKegiatan', 'user'])
            ->where('id_aset', $aset->id)->latest('created_at')->paginate(10);
        $masterKegiatan = MasterKegiatan::all();
        $kepemilikan = Kepemilikan::all();
        $jenis = Jenis::all();

        return view('kegiatan.index', compact('aset', 'kegiatan', 'masterKegiatan', 'kepemilikan', 'jenis'));
    }

    private function handleFileUpload($request, $fieldName, $directory)
    {
        if ($request->hasFile($fieldName)) {
            $file = $request->file($fieldName);
            $fileName = time() . '_' . $file->getClientOriginalName();

            // masuk ke directory folder khusus sesuai namanya
            $path = $file->storeAs("public/{$directory}", $fileName);

            return str_replace('public/', '', $path);
        }

        return null;
    }


    public function store(Request $request, $uuid)
    {
        $aset = Aset::where('id', $uuid)->firstOrFail();

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'id_master_kegiatan' => 'required|exists:master_kegiatans,id',
            'note' => 'nullable|string|required_if:is_custom,1',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password tidak valid!'],
            ]);
        }

        $masterKegiatan = MasterKegiatan::findOrFail($request->id_master_kegiatan);

        // Handle upload
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $storagePath = 'kegiatan/' . $fileName;

            $image = imagecreatefromjpeg($file->getRealPath());

            $width = imagesx($image);
            $height = imagesy($image);

            $newWidth = min($width, 1920);
            $newHeight = floor($height * ($newWidth / $width));

            $newImage = imagecreatetruecolor($newWidth, $newHeight);

            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            imagejpeg($newImage, storage_path('app/public/' . $storagePath), 75);

            imagedestroy($image);
            imagedestroy($newImage);

            $fotoPath = $storagePath;
        }

        Kegiatan::create([
            'id_aset' => $aset->id,
            'id_user' => $user->id,
            'id_master_kegiatan' => $masterKegiatan->id,
            'note' => $masterKegiatan->is_custom ? $request->note : null,
            'foto' => $fotoPath,
        ]);

        return redirect()->route('kegiatan.index', ['uuid' => $aset->id])
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function updateMaster(Request $request, $uuid)
    {
        // Validasi req
        $validatedData = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'id_master_jenis' => 'required',
            'nama_barang' => 'required',
            'nomor_aset' => 'required',
            'serial_number' => 'required',
            'part_number' => 'required',
            'pengguna' => 'required',
            'lokasi' => 'nullable|string',
            'foto_aset' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tahun_kepemilikan' => 'required|numeric',
            'status' => 'required',
            'id_kepemilikan' => 'required',
            'spek' => 'required',
        ]);

        // Verif kredensial
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Username atau password tidak valid!');
        }

        try {
            unset($validatedData['username']);
            unset($validatedData['password']);

            $aset = Aset::findOrFail($uuid);

            // Handle foto_aset upload with compression
            if ($request->hasFile('foto_aset')) {
                // Hapus foto lama jika ada
                if ($aset->foto_aset && Storage::exists('public/' . $aset->foto_aset)) {
                    Storage::delete('public/' . $aset->foto_aset);
                }

                // Upload dan compress foto baru
                $file = $request->file('foto_aset');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $storagePath = 'aset/' . $fileName;

                // Kompresi gambar
                $image = imagecreatefromstring(file_get_contents($file->getRealPath()));

                $width = imagesx($image);
                $height = imagesy($image);

                $newWidth = min($width, 1920);
                $newHeight = floor($height * ($newWidth / $width));

                $newImage = imagecreatetruecolor($newWidth, $newHeight);

                // Untuk mendukung transparansi pada PNG
                if ($file->getClientOriginalExtension() == 'png') {
                    imagealphablending($newImage, false);
                    imagesavealpha($newImage, true);
                    $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                    imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
                }

                imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

                // Simpan gambar dengan kompresi
                if ($file->getClientOriginalExtension() == 'png') {
                    imagepng($newImage, storage_path('app/public/' . $storagePath), 7);
                } else {
                    imagejpeg($newImage, storage_path('app/public/' . $storagePath), 75);
                }

                imagedestroy($image);
                imagedestroy($newImage);

                $validatedData['foto_aset'] = $storagePath;
            }

            $aset->update($validatedData);

            return redirect()->route('kegiatan.index', ['uuid' => $aset->id])
                ->with('success', 'Data aset berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data aset: ' . $e->getMessage());
        }
    }

    public function destroy(string $uuid, string $kegiatan)
    {
        $kegiatan = Kegiatan::where('id', $kegiatan)->where('id_aset', $uuid)->firstOrFail();
        $kegiatan->delete();

        return redirect()->route('aset.index')->with('success', 'Data kegiatan berhasil dihapus');;
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
