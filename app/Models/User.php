<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'otp',
        'otp_expired_at',
        'division',
        'avatar', // 🔥 WAJIB
    ];

    /**
     * Hidden attributes
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'otp_expired_at' => 'datetime',
    ];

    /**
     * 🔐 Generate OTP (TANPA kirim email)
     */
    public function generateOtp(): int
    {
        $otp = random_int(100000, 999999);

        $this->update([
            'otp' => $otp,
            'otp_expired_at' => now()->addMinutes(5),
        ]);

        return $otp;
    }

    /**
     * 📧 Kirim OTP (dipisah biar clean)
     */
    public function sendOtp(): void
    {
        if (!$this->otp) {
            $this->generateOtp();
        }

        Mail::html("
            <div style='font-family:Arial,sans-serif'>
                <h2>TRINET OTP</h2>
                <p>Mohon verifikasi OTP untuk login.</p>

                <div style='
                    font-size:32px;
                    font-weight:bold;
                    letter-spacing:6px;
                    margin:20px 0;
                '>
                    {$this->otp}
                </div>

                <p style='color:#888'>Berlaku 5 menit</p>
            </div>
        ", function ($msg) {
            $msg->to($this->email)
                ->subject('Kode OTP Login - TRINET');
        });
    }

    /**
     * ✅ Verify OTP
     */
    public function verifyOtp(string $inputOtp): bool
    {
        if (!$this->otp || !$this->otp_expired_at) {
            return false;
        }

        return (string) $this->otp === (string) $inputOtp
            && now()->lt($this->otp_expired_at);
    }

    /**
     * ♻️ Reset OTP
     */
    public function clearOtp(): void
    {
        $this->update([
            'otp' => null,
            'otp_expired_at' => null,
        ]);
    }

    /**
     * 🎯 Helper Role
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isSales(): bool
    {
        return $this->hasRole('sales');
    }

    /**
     * 🎯 Division Label
     */
    public function getDivisionLabelAttribute(): string
    {
        return match ($this->division) {
            'network' => 'Network',
            'system' => 'System',
            'iot' => 'IoT',
            'security' => 'Security',
            'app' => 'Application',
            'sales' => 'Sales',
            'presales' => 'Pre Sales',
            'project' => 'Project',
            default => 'Unknown',
        };
    }

    public function getAvatarUrlAttribute(): string
{
    // ✅ kalau ada upload
    if ($this->avatar) {
        return asset('storage/' . $this->avatar);
    }

    // 🔥 ambil nama
    $name = $this->name ?? 'User';

    // 🔥 ambil 2 huruf inisial
    $initials = collect(explode(' ', $name))
        ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
        ->take(2)
        ->implode('');

    // 🔥 warna konsisten dari nama
    $colors = ['0D8ABC', '6F42C1', '198754', 'DC3545', 'FD7E14'];
    $color = $colors[crc32($name) % count($colors)];

    return "https://ui-avatars.com/api/?name={$initials}&background={$color}&color=fff&size=128";
}
}