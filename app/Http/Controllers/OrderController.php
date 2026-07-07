<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Order;
use App\Models\Allocation;
use App\Models\QrCode as QrCodeModel;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Store the order
    public function store(Request $request, Campaign $campaign)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        // Check campaign is still active
        if ($campaign->status !== 'active') {
            return redirect()->back()->with('error', 'Kampanye ini sudah tidak aktif.');
        }

        // Check remaining quantity
        $remaining = $campaign->remainingQuantity();
        if ($request->quantity > $remaining && $remaining > 0) {
            return redirect()->back()->with('error', "Sisa kuota hanya {$remaining} unit.");
        }

        $subtotal = $request->quantity * $campaign->price_per_unit;
        $totalPrice = $subtotal * 1.05; // Tambahan 5% biaya platform

        $order = Order::create([
            'user_id' => Auth::id(),
            'campaign_id' => $campaign->id,
            'quantity' => $request->quantity,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        // Update campaign current amount
        $campaign->increment('current_amount', $request->quantity);

        return redirect()->route('order.payment', $order->id);
    }

    // Show payment simulation page
    public function payment(Order $order)
    {
        $order->load('campaign');
        return view('payment', compact('order'));
    }

    // Complete payment simulation
    public function completePayment(Order $order)
    {
        $order->update(['status' => 'paid']);

        // Create Payment record
        Payment::create([
            'order_id' => $order->id,
            'amount' => $order->total_price,
            'payment_method' => 'Virtual Account',
            'status' => 'success',
            'paid_at' => now(),
        ]);

        // Create Allocation for pickup
        $allocation = Allocation::create([
            'order_id' => $order->id,
            'user_id' => $order->user_id,
            'quantity_allocated' => $order->quantity,
            'status' => 'allocated',
        ]);

        // Create QR Code record
        $code = 'QR-' . strtoupper(uniqid());
        QrCodeModel::create([
            'allocation_id' => $allocation->id,
            'code' => $code,
            'is_scanned' => false,
        ]);

        return redirect()->route('kupon.show', $allocation->id)->with('success', 'Pembayaran berhasil, kupon Anda telah terbit.');
    }
}
