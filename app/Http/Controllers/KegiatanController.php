<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kegiatan;
use App\Models\Kepemilikan;
use App\Models\MasterJenis;
use App\Models\MasterKegiatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class KegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($uuid)
    {
        $aset = Aset::findOrFail($uuid); // Ensure the UUID is correctly passed
        $kegiatan = Kegiatan::with(['masterKegiatan', 'user'])
            ->where('id_aset', $aset->id)->latest('created_at')->paginate(10);
        $masterKegiatan = MasterKegiatan::all();
        $kepemilikan = Kepemilikan::all();
        $masterJenis = MasterJenis::all();

        return view('kegiatan.index', compact('aset', 'kegiatan', 'masterKegiatan', 'kepemilikan', 'masterJenis'));
    }


    public function store(Request $request, $uuid)
    {
        $aset = Aset::where('id', $uuid)->firstOrFail();

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'id_master_kegiatan' => 'required|exists:master_kegiatans,id',
            'id_master_jenis' => 'required|exists:master_jenis,id',
            'custom_kegiatan' => 'nullable|string|required_if:is_custom,1',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password tidak valid!'],
            ]);
        }

        // Get the selected MasterKegiatan
        $masterKegiatan = MasterKegiatan::findOrFail($request->id_master_kegiatan);
        $masterJenis = MasterJenis::findOrFail($request->id_master_jenis);

        // Create kegiatan with proper handling of custom_kegiatan
        Kegiatan::create([
            'id_aset' => $aset->id,
            'id_user' => $user->id,
            'id_master_kegiatan' => $masterKegiatan->id,
            'id_master_jenis' => $masterJenis->id,
            'custom_kegiatan' => $masterKegiatan->is_custom ? $request->custom_kegiatan : null,
        ]);

        return redirect()->route('kegiatan.index', ['uuid' => $aset->id])
            ->with('success', 'Kegiatan berhasil ditambahkan');
    }

    public function updateMaster(Request $request, $uuid)
    {
        // Validate request
        $validatedData = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'id_master_jenis' => 'required',
            'nama_barang' => 'required',
            'nomor_aset' => 'required',
            'serial_number' => 'required',
            'part_number' => 'required',
            'pengguna' => 'required',
            'tahun_kepemilikan' => 'required|numeric',
            'foto' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'id_kepemilikan' => 'required',
            'spek' => 'required',
        ]);

        // Verify credentials
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()
            ->withInput()
            ->with('error', 'Username atau password tidak valid!');    
        }

        try {
            // Remove credentials from validatedData before updating
            unset($validatedData['username']);
            unset($validatedData['password']);

            // Update the asset
            $aset = Aset::findOrFail($uuid);
            $aset->update($validatedData);

            return redirect()->route('kegiatan.index', ['uuid' => $aset->id])
                ->with('success', 'Data aset berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan saat memperbarui data aset');
        }
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
