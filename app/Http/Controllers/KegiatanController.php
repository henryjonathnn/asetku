<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Kegiatan;
use App\Models\User;
use Illuminate\Http\Request;
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
        $kegiatan = Kegiatan::where('id_aset', $aset->id)->get();
        $user = User::all();
    
        return view('kegiatan.index', compact('aset', 'kegiatan', 'user'));
    }
    

    public function store(Request $request, $uuid)
    {
        $aset = Aset::where('id', $uuid)->firstOrFail(); // Pastikan UUID cocok

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'kegiatan' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'username' => ['Username atau password tidak valid!'],
            ]);
        }

        Kegiatan::create([
            'id_aset' => $aset->id, // Pastikan ini mengacu pada ID yang ada di tabel `asets`
            'id_user' => $user->id,
            'kegiatan' => $request->kegiatan,
        ]);

        // Redirect to the kegiatan.index route with the uuid
        return redirect()->route('kegiatan.index', ['uuid' => $aset->id]);
    }


    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
