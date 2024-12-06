<?php

namespace App\Http\Controllers;

use App\Models\Jenis;
use App\Models\Kepemilikan;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type', 'jenis');
        $data = [];
        
        if ($type === 'jenis') {
            $data = Jenis::orderBy('created_at', 'desc')->get();
        } else if ($type === 'kepemilikan') {
            $data = Kepemilikan::orderBy('created_at', 'desc')->get();
        } else {
            abort(404);
        }
        
        return view('master.index', compact('data', 'type'));
    }

    public function store(Request $request)
    {
        $type = $request->type;
        
        if ($type === 'jenis') {
            $request->validate([
                'jenis' => 'required|string|max:255|unique:jenis,jenis'
            ]);

            Jenis::create([
                'jenis' => $request->jenis,
                'is_active' => true
            ]);
            
            $message = 'Data jenis berhasil ditambahkan';
        } else if ($type === 'kepemilikan') {
            $request->validate([
                'kepemilikan' => 'required|string|max:255|unique:kepemilikans,kepemilikan'
            ]);

            Kepemilikan::create([
                'kepemilikan' => $request->kepemilikan,
                'is_active' => true
            ]);
            
            $message = 'Data kepemilikan berhasil ditambahkan';
        }

        return redirect()->route('master.index', ['type' => $type])->with('success', $message);
    }

    public function update(Request $request, $id)
    {
        $type = $request->type;
        
        if ($type === 'jenis') {
            $item = Jenis::findOrFail($id);
            $request->validate([
                'jenis' => 'required|string|max:255|unique:jenis,jenis,' . $id
            ]);

            $item->update([
                'jenis' => $request->jenis,
                'is_active' => $request->has('is_active')
            ]);
            
            $message = 'Data jenis berhasil diperbarui';
        } else if ($type === 'kepemilikan') {
            $item = Kepemilikan::findOrFail($id);
            $request->validate([
                'kepemilikan' => 'required|string|max:255|unique:kepemilikans,kepemilikan,' . $id
            ]);

            $item->update([
                'kepemilikan' => $request->kepemilikan,
                'is_active' => $request->has('is_active')
            ]);
            
            $message = 'Data kepemilikan berhasil diperbarui';
        }

        return redirect()->route('master.index', ['type' => $type])->with('success', $message);
    }
}