<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class KuponController extends Controller
{
    public function show(Allocation $allocation)
    {
        $qrRecord = $allocation->qrCode;
        
        if (!$qrRecord) {
            abort(404, 'QR Code tidak ditemukan');
        }

        // Generate actual QR code SVG
        $qrImage = QrCode::size(250)->generate($qrRecord->code);

        return view('kupon', compact('allocation', 'qrRecord', 'qrImage'));
    }
}
