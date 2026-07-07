<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Relationships ──

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function gapoktan()
    {
        return $this->hasOne(Gapoktan::class);
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class);
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }

    // ── Role Helpers ──

    public function isPetani(): bool
    {
        return $this->role === 'petani';
    }

    public function isKetua(): bool
    {
        return $this->role === 'ketua';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
