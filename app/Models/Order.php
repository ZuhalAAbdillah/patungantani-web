<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }

    // ── Relationships ──

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function allocation()
    {
        return $this->hasOne(Allocation::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
