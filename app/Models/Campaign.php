<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'closes_at' => 'datetime',
            'price_per_unit' => 'decimal:2',
            'margin_per_unit' => 'decimal:2',
        ];
    }

    // ── Relationships ──

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ── Helpers ──

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function progressPercent(): int
    {
        if ($this->target_amount <= 0) return 0;
        $ordered = $this->orders()->sum('quantity');
        return min(100, round(($ordered / $this->target_amount) * 100));
    }

    public function orderedQuantity(): int
    {
        return (int) $this->orders()->sum('quantity');
    }

    public function remainingQuantity(): int
    {
        return max(0, $this->target_amount - $this->orderedQuantity());
    }
}
