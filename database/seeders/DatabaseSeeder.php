<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Campaign;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Allocation;
use App\Models\QrCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ── Users ──
        $admin = User::create([
            'name' => 'Admin PatunganTani',
            'email' => 'admin@patungantani.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '081200000000',
        ]);

        $ketua = User::create([
            'name' => 'Bpk. Supriadi',
            'email' => 'ketua@patungantani.id',
            'password' => Hash::make('password'),
            'role' => 'ketua',
            'phone' => '081234567890',
        ]);

        $ketua2 = User::create([
            'name' => 'Ibu Siti Aminah',
            'email' => 'ketua2@patungantani.id',
            'password' => Hash::make('password'),
            'role' => 'ketua',
            'phone' => '081298765432',
        ]);

        $petani1 = User::create([
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad@petani.id',
            'password' => Hash::make('password'),
            'role' => 'petani',
            'phone' => '081300000001',
        ]);

        $petani2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@petani.id',
            'password' => Hash::make('password'),
            'role' => 'petani',
            'phone' => '081300000002',
        ]);

        $petani3 = User::create([
            'name' => 'Dewi Kartika',
            'email' => 'dewi@petani.id',
            'password' => Hash::make('password'),
            'role' => 'petani',
            'phone' => '081300000003',
        ]);

        $petani4 = User::create([
            'name' => 'Eko Prasetyo',
            'email' => 'eko@petani.id',
            'password' => Hash::make('password'),
            'role' => 'petani',
        ]);

        $petani5 = User::create([
            'name' => 'Fitri Handayani',
            'email' => 'fitri@petani.id',
            'password' => Hash::make('password'),
            'role' => 'petani',
        ]);

        // ── Campaigns ──
        $campaign1 = Campaign::create([
            'user_id' => $ketua->id,
            'title' => 'Pupuk NPK Phonska Non-Sub - MT Gadu 2026',
            'description' => 'Pupuk NPK 15-15-15 kemasan 50kg, kualitas pabrik langsung. Ideal untuk padi musim tanam gadu.',
            'target_amount' => 200,
            'current_amount' => 85,
            'price_per_unit' => 285000,
            'status' => 'active',
            'closes_at' => now()->addDays(14),
        ]);

        $campaign2 = Campaign::create([
            'user_id' => $ketua->id,
            'title' => 'Pupuk Urea Granul - Stok Musiman',
            'description' => 'Pupuk Urea 46% N kemasan 50kg untuk pemupukan susulan.',
            'target_amount' => 150,
            'current_amount' => 150,
            'price_per_unit' => 195000,
            'status' => 'active',
            'closes_at' => now()->addDays(7),
        ]);

        $campaign3 = Campaign::create([
            'user_id' => $ketua2->id,
            'title' => 'Pestisida Organik Bio-Protector',
            'description' => 'Pestisida organik berbahan dasar neem untuk pengendalian hama terpadu.',
            'target_amount' => 100,
            'current_amount' => 30,
            'price_per_unit' => 125000,
            'status' => 'active',
            'closes_at' => now()->addDays(21),
        ]);

        // ── Orders for Campaign 1 (Pupuk NPK) ──
        $orders = [
            ['user' => $petani1, 'qty' => 25],
            ['user' => $petani2, 'qty' => 20],
            ['user' => $petani3, 'qty' => 15],
            ['user' => $petani4, 'qty' => 15],
            ['user' => $petani5, 'qty' => 10],
        ];

        foreach ($orders as $o) {
            $order = Order::create([
                'user_id' => $o['user']->id,
                'campaign_id' => $campaign1->id,
                'quantity' => $o['qty'],
                'total_price' => $o['qty'] * $campaign1->price_per_unit,
                'status' => 'paid',
            ]);

            // Payment
            Payment::create([
                'order_id' => $order->id,
                'amount' => $order->total_price,
                'payment_method' => 'Virtual Account',
                'status' => 'success',
                'paid_at' => now()->subDays(rand(1, 5)),
            ]);

            // Allocation
            $allocation = Allocation::create([
                'order_id' => $order->id,
                'user_id' => $o['user']->id,
                'quantity_allocated' => $o['qty'],
                'status' => 'allocated',
            ]);

            // QR Code
            QrCode::create([
                'allocation_id' => $allocation->id,
                'code' => 'QR-' . strtoupper(uniqid()),
                'is_scanned' => false,
            ]);
        }

        // ── Orders for Campaign 2 (Urea) - fully ordered ──
        $orders2 = [
            ['user' => $petani1, 'qty' => 50],
            ['user' => $petani2, 'qty' => 40],
            ['user' => $petani3, 'qty' => 30],
            ['user' => $petani4, 'qty' => 20],
            ['user' => $petani5, 'qty' => 10],
        ];

        foreach ($orders2 as $i => $o) {
            $isPaid = $i < 3; // first 3 are paid, rest pending
            $order = Order::create([
                'user_id' => $o['user']->id,
                'campaign_id' => $campaign2->id,
                'quantity' => $o['qty'],
                'total_price' => $o['qty'] * $campaign2->price_per_unit,
                'status' => $isPaid ? 'paid' : 'pending',
            ]);

            if ($isPaid) {
                Payment::create([
                    'order_id' => $order->id,
                    'amount' => $order->total_price,
                    'payment_method' => 'Virtual Account',
                    'status' => 'success',
                    'paid_at' => now()->subDays(rand(1, 3)),
                ]);

                $allocation = Allocation::create([
                    'order_id' => $order->id,
                    'user_id' => $o['user']->id,
                    'quantity_allocated' => $o['qty'],
                    'status' => $i === 0 ? 'picked_up' : 'allocated', // first one already picked up
                ]);

                $qr = QrCode::create([
                    'allocation_id' => $allocation->id,
                    'code' => 'QR-' . strtoupper(uniqid()),
                    'is_scanned' => $i === 0,
                    'scanned_at' => $i === 0 ? now()->subHours(2) : null,
                ]);
            }
        }

        // ── Orders for Campaign 3 (Pestisida) ──
        $order3 = Order::create([
            'user_id' => $petani1->id,
            'campaign_id' => $campaign3->id,
            'quantity' => 15,
            'total_price' => 15 * $campaign3->price_per_unit,
            'status' => 'paid',
        ]);

        Payment::create([
            'order_id' => $order3->id,
            'amount' => $order3->total_price,
            'payment_method' => 'Virtual Account',
            'status' => 'success',
            'paid_at' => now()->subDays(1),
        ]);

        $allocation3 = Allocation::create([
            'order_id' => $order3->id,
            'user_id' => $petani1->id,
            'quantity_allocated' => 15,
            'status' => 'allocated',
        ]);

        QrCode::create([
            'allocation_id' => $allocation3->id,
            'code' => 'QR-' . strtoupper(uniqid()),
            'is_scanned' => false,
        ]);

        // Pending order for petani2 on campaign 3
        Order::create([
            'user_id' => $petani2->id,
            'campaign_id' => $campaign3->id,
            'quantity' => 15,
            'total_price' => 15 * $campaign3->price_per_unit,
            'status' => 'pending',
        ]);

        $this->command->info('✅ Seeder berhasil! Akun demo:');
        $this->command->info('  Admin:  admin@patungantani.id / password');
        $this->command->info('  Ketua:  ketua@patungantani.id / password');
        $this->command->info('  Petani: ahmad@petani.id / password');
    }
}
