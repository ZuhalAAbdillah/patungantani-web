<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'is_scanned' => 'boolean',
            'scanned_at' => 'datetime',
        ];
    }

    // ── Relationships ──

    public function allocation()
    {
        return $this->belongsTo(Allocation::class);
    }
}
