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
        // Generate URL directly to the kegiatan route without signing
        $url = route('kegiatan.index', ['uuid' => $uuid]);

        // Generate QR code with consistent settings
        return [
            'qrcode' => DNS2DFacade::getBarcodeSVG($url, 'QRCODE', $width, $height),
            'url' => $url
        ];
    }

    public function generate($uuid)
    {
        $aset = Aset::findOrFail($uuid);
        $width = 4;
        $height = 4;

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
            // Use same size as modal for consistency
            $qrData = $this->generateQRCode($aset->id, 4, 4);

            $asetsWithQR[] = [
                'aset' => $aset,
                'qrcode' => $qrData['qrcode'],
                'url' => $qrData['url']
            ];
        }

        return view('barcode.print-multiple', compact('asetsWithQR'));
    }
}