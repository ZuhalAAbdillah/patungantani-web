<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gapoktan extends Model
{
    protected $guarded = [];

    // ── Relationships ──

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
