<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Milon\Barcode\Facades\DNS2DFacade;

class BarcodeController extends Controller
{
    private function generateQRCode($uuid, $width = 4, $height = 4)
    {
        $url = route('kegiatan.index', ['uuid' => $uuid]);


        return [
            'qrcode' => DNS2DFacade::getBarcodeSVG($url, 'QRCODE', $width, $height),
            'url' => $url
        ];
    }

    public function generate($uuid)
    {
        $aset = Aset::findOrFail($uuid);
        $width = 2;
        $height = 2;

        $qrData = $this->generateQRCode($aset->id, $width, $height);

        return view('barcode.index', [
            'qrcode' => $qrData['qrcode'],
            'aset' => $aset,
            'width' => $width,
            'height' => $height,
            'url' => $qrData['url']
        ]);
    }

    public function printBulkQRCodes(Request $request)
    {
        $asetIds = $request->input('selected_asets', []);
        $asetsWithQR = [];

        foreach ($asetIds as $uuid) {
            $aset = Aset::findOrFail($uuid);

            $qrData = $this->generateQRCode($aset->id, 2, 2);

            $asetsWithQR[] = [
                'aset' => $aset,
                'qrcode' => $qrData['qrcode'],
                'url' => $qrData['url']
            ];
        }

        return view('barcode.print-multiple', compact('asetsWithQR'));
    }
}