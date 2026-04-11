<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class VerifyOtp extends Page
{
    protected static ?string $navigationIcon = null;

    protected static string $view = 'filament.pages.verify-otp';

    protected static bool $shouldRegisterNavigation = false;

    public string $otp = '';

    // 🔥 PENTING: biar bisa diakses tanpa login
    public static function canAccess(): bool
    {
        return true;
    }

    public function verify()
    {
        $userId = Session::get('otp_user_id');

        if (!$userId) {
            return redirect('/admin/login');
        }

        $user = User::find($userId);

        if (!$user || !$user->verifyOtp($this->otp)) {
            $this->addError('otp', 'OTP salah atau expired');
            return;
        }

        // ✅ LOGIN SETELAH OTP BENAR
        Auth::login($user);

        // 🔥 CLEAR SESSION
        Session::forget(['otp_user_id', 'otp_attempts']);

        // 🔥 HAPUS OTP
        $user->clearOtp();

        return redirect('/admin');
    }
}