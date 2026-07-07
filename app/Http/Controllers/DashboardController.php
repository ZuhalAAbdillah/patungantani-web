<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Campaign;
use App\Models\Order;
use App\Models\Payment;
use App\Models\QrCode as QrCodeModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Landing page: guest sees welcome, logged-in users get redirected to dashboard.
     */
    public function welcome()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        $campaigns = Campaign::where('status', 'active')->latest()->get();

        // Stats for hero section
        $totalFarmers = User::where('role', 'petani')->count();
        $totalCampaigns = Campaign::where('status', 'active')->count();
        $totalVolume = Order::where('status', 'paid')->sum('quantity');

        return view('welcome', compact('campaigns', 'totalFarmers', 'totalCampaigns', 'totalVolume'));
    }

    /**
     * Dashboard: role-based routing to the correct dashboard view.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        if ($user->isKetua()) {
            return $this->ketuaDashboard($user);
        }

        return $this->petaniDashboard($user);
    }

    private function petaniDashboard($user)
    {
        $orders = Order::with(['campaign', 'allocation.qrCode'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $activeCampaigns = Campaign::where('status', 'active')->latest()->get();

        $totalOrders = $orders->count();
        $totalSpent = $orders->where('status', 'paid')->sum('total_price');
        $totalQuantity = $orders->where('status', 'paid')->sum('quantity');
        $activeKupons = $orders->filter(function ($order) {
            return $order->allocation && $order->allocation->status === 'allocated';
        })->count();
        $redeemedKupons = $orders->filter(function ($order) {
            return $order->allocation && $order->allocation->status === 'redeemed';
        })->count();
        $pendingPayments = $orders->where('status', 'pending')->count();
        $estimatedSavings = $totalSpent * 0.15; // 15% savings estimate vs retail

        return view('dashboard.petani', compact(
            'orders', 'activeCampaigns', 'totalOrders', 'totalSpent',
            'totalQuantity', 'activeKupons', 'redeemedKupons',
            'pendingPayments', 'estimatedSavings'
        ));
    }

    private function ketuaDashboard($user)
    {
        // ── Active Campaign ──
        $campaign = Campaign::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$campaign) {
            // Fallback: cek juga campaign aktif lain (untuk demo)
            $campaign = Campaign::where('status', 'active')->latest()->first();
        }

        // ── All Campaigns for History ──
        $allCampaigns = Campaign::where('user_id', $user->id)
            ->latest()
            ->get();

        if (!$campaign) {
            return view('dashboard.ketua', [
                'campaign' => null,
                'orders' => collect(),
                'totalVolume' => 0,
                'totalPrice' => 0,
                'allCampaigns' => $allCampaigns,
                'daysLeft' => 0,
                'paidTotal' => 0,
                'unpaidTotal' => 0,
                'memberCount' => 0,
                'distributedCount' => 0,
                'pendingDistribution' => 0,
                'recentActivity' => collect(),
                'komisiKetua' => 0,
                'potensiKomisi' => 0,
            ]);
        }

        $orders = Order::with(['user', 'allocation.qrCode', 'payment'])
            ->where('campaign_id', $campaign->id)
            ->latest()
            ->get();

        $totalVolume = $orders->sum('quantity');
        $totalPrice = $orders->sum('total_price');

        // ── Deadline Countdown ──
        $daysLeft = $campaign->closes_at ? (int) max(0, now()->diffInDays($campaign->closes_at, false)) : 0;

        // ── Payment Breakdown ──
        $paidOrders = $orders->where('status', 'paid');
        $pendingOrders = $orders->where('status', 'pending');
        $paidTotal = $paidOrders->sum('total_price');
        $unpaidTotal = $pendingOrders->sum('total_price');

        // ── Komisi Ketua (40% dari 5% Platform Fee) ──
        $paidPlatformFee = $paidTotal - ($paidTotal / 1.05);
        $pendingPlatformFee = $unpaidTotal - ($unpaidTotal / 1.05);
        $komisiKetua = $paidPlatformFee * 0.40;
        $potensiKomisi = $pendingPlatformFee * 0.40;

        // ── Unique Members ──
        $memberCount = $orders->pluck('user_id')->unique()->count();

        // ── Distribution Stats ──
        $distributedCount = $orders->filter(function ($order) {
            return $order->allocation && $order->allocation->status === 'picked_up';
        })->count();
        $pendingDistribution = $orders->filter(function ($order) {
            return $order->status === 'paid' && (!$order->allocation || $order->allocation->status !== 'picked_up');
        })->count();

        // ── Recent Activity Feed ──
        $recentActivity = collect();

        // Orders activity
        foreach ($orders->take(20) as $order) {
            $recentActivity->push([
                'type' => 'order',
                'icon' => 'cart',
                'text' => ($order->user->name ?? 'Anggota') . ' memesan ' . $order->quantity . ' karung',
                'time' => $order->created_at,
                'color' => '#6366F1',
                'bg' => '#E0E7FF',
            ]);

            // Payment activity
            if ($order->status === 'paid') {
                $paidAt = $order->payment->paid_at ?? $order->updated_at;
                $recentActivity->push([
                    'type' => 'payment',
                    'icon' => 'cash',
                    'text' => ($order->user->name ?? 'Anggota') . ' melunasi Rp ' . number_format($order->total_price, 0, ',', '.'),
                    'time' => $paidAt,
                    'color' => '#16A34A',
                    'bg' => '#DCFCE7',
                ]);
            }

            // Distribution activity
            if ($order->allocation && $order->allocation->status === 'picked_up') {
                $scannedAt = $order->allocation->qrCode->scanned_at ?? $order->allocation->updated_at;
                $recentActivity->push([
                    'type' => 'distribution',
                    'icon' => 'check',
                    'text' => ($order->user->name ?? 'Anggota') . ' mengambil saprotan',
                    'time' => $scannedAt,
                    'color' => '#7C3AED',
                    'bg' => '#EDE9FE',
                ]);
            }
        }

        // Sort by time desc, take 10 most recent
        $recentActivity = $recentActivity->sortByDesc('time')->take(10)->values();

        return view('dashboard.ketua', compact(
            'campaign', 'orders', 'totalVolume', 'totalPrice',
            'allCampaigns', 'daysLeft', 'paidTotal', 'unpaidTotal',
            'memberCount', 'distributedCount', 'pendingDistribution',
            'recentActivity', 'komisiKetua', 'potensiKomisi'
        ));
    }

    private function adminDashboard()
    {
        $totalUsers = User::count();
        $totalPetani = User::where('role', 'petani')->count();
        $totalKetua = User::where('role', 'ketua')->count();
        $totalCampaigns = Campaign::count();
        $activeCampaigns = Campaign::where('status', 'active')->count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');

        $recentCampaigns = Campaign::with('creator')->latest()->take(5)->get();
        $recentOrders = Order::with(['user', 'campaign'])->latest()->take(10)->get();
        $recentUsers = User::latest()->take(5)->get();

        return view('dashboard.admin', compact(
            'totalUsers', 'totalPetani', 'totalKetua',
            'totalCampaigns', 'activeCampaigns',
            'totalOrders', 'totalRevenue',
            'recentCampaigns', 'recentOrders', 'recentUsers'
        ));
    }

    public function finance()
    {
        // 1. Total Omset (dari order berstatus paid)
        $totalRevenue = Order::where('status', 'paid')->sum('total_price');

        // 2. Potensi Pendapatan (dari order berstatus pending)
        $potentialRevenue = Order::where('status', 'pending')->sum('total_price');

        // 3. Estimasi Laba Bersih Admin (60% dari 5% Platform Fee)
        // Platform fee adalah bagian dari total_price. total_price = subtotal * 1.05
        // Total Revenue = total_price
        // Platform Fee = Total Revenue - (Total Revenue / 1.05)
        $platformFee = $totalRevenue - ($totalRevenue / 1.05);
        $estimatedProfit = $platformFee * 0.60;
        $totalKetuaProfit = $platformFee * 0.40;

        // 4. Data Kampanye untuk detail tabel
        $campaigns = Campaign::with(['creator', 'orders'])->latest()->get()->map(function ($campaign) {
            $paidOrders = $campaign->orders->where('status', 'paid');
            $pendingOrders = $campaign->orders->where('status', 'pending');
            
            $omset = $paidOrders->sum('total_price');
            $potensi = $pendingOrders->sum('total_price');
            $campPlatformFee = $omset - ($omset / 1.05);
            $laba = $campPlatformFee * 0.60;
            $komisiKetua = $campPlatformFee * 0.40;
            
            $campaign->omset = $omset;
            $campaign->potensi = $potensi;
            $campaign->laba = $laba;
            $campaign->komisi_ketua = $komisiKetua;
            $campaign->paid_volume = $paidOrders->sum('quantity');

            return $campaign;
        });

        return view('dashboard.finance', compact(
            'totalRevenue', 'potentialRevenue', 'estimatedProfit', 'totalKetuaProfit', 'campaigns'
        ));
    }

    public function exportCsv(Request $request)
    {
        $user = Auth::user();

        $campaign = Campaign::where('user_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$campaign) {
            $campaign = Campaign::where('status', 'active')->latest()->first();
        }

        if (!$campaign) {
            return redirect()->back()->with('error', 'Tidak ada kampanye aktif.');
        }

        $orders = Order::with('user')->where('campaign_id', $campaign->id)->get();

        $filename = 'rekap_pesanan_' . str_replace(' ', '_', strtolower($campaign->title)) . '_' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($orders, $campaign) {
            $file = fopen('php://output', 'w');
            // BOM for UTF-8
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['No', 'Nama Petani', 'Komoditas', 'Qty (Karung)', 'Subtotal (Rp)', 'Status', 'Tanggal Order']);

            foreach ($orders as $i => $order) {
                fputcsv($file, [
                    $i + 1,
                    $order->user->name ?? 'Anggota',
                    $campaign->title,
                    $order->quantity,
                    number_format($order->total_price, 0, ',', '.'),
                    ucfirst($order->status),
                    $order->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
