<?php

namespace App\Http\Controllers;

use App\Models\QrCode as QrCodeModel;
use App\Models\Allocation;
use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function index()
    {
        $logs = QrCodeModel::with(['allocation.order.user', 'allocation.order.campaign'])
            ->where('is_scanned', true)
            ->latest('updated_at')
            ->get();

        return view('scan', compact('logs'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'qr_code' => 'required|string',
        ]);

        $qrCode = QrCodeModel::where('code', $request->qr_code)->first();

        if (!$qrCode) {
            return redirect()->back()->with('error', 'Kupon QR tidak valid atau tidak ditemukan.');
        }

        $campaign = $qrCode->allocation->order->campaign ?? null;
        if ($campaign && !$campaign->isTargetReached()) {
            return redirect()->back()->with('error', 'Kupon ini belum aktif. Kuota patungan kampanye belum terpenuhi.');
        }

        if ($qrCode->is_scanned) {
            return redirect()->back()->with('error', 'Kupon sudah pernah di-scan sebelumnya pada ' . $qrCode->updated_at->format('d M Y H:i'));
        }

        // Mark as scanned
        $qrCode->update([
            'is_scanned' => true,
            'scanned_at' => now(),
        ]);

        // Update allocation status
        $allocation = Allocation::find($qrCode->allocation_id);
        if ($allocation) {
            $allocation->update(['status' => 'picked_up']);
        }

        return redirect()->back()->with('success', 'Verifikasi berhasil! Saprotan dapat diserahkan kepada Petani.');
    }
}
