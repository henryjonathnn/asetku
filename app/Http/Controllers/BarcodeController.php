<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\Facades\DNS2DFacade;

class BarcodeController extends Controller
{
    public function generate($uuid)
    {
        $aset = Aset::findOrFail($uuid);

        // Sesuaikan ukuran QR code yang lebih besar
        $width = 5;
        $height = 5;

        $url = URL::signedRoute('kegiatan.index', ['uuid' => $aset->id]);
        $qrcode = DNS2DFacade::getBarcodeSVG($url, 'QRCODE', $width, $height);

        return view('barcode.index', compact('qrcode', 'aset', 'width', 'height', 'url'));
    }
}