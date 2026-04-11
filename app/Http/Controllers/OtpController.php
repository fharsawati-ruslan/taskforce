<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OtpController extends Controller
{
    public function verify(Request $request)
    {
        // 🔥 GABUNGKAN OTP DARI ARRAY
        $otp = implode('', $request->otp);

        $user = User::find(session('otp_user_id'));

        if (!$user) {
            return redirect('/admin/login');
        }

        // 🔐 VALIDASI OTP (SUDAH FIX)
        if (trim($user->otp) !== trim($otp)) {
            return back()->withErrors(['otp' => 'OTP salah']);
        }

        // ⏱ CEK EXPIRED
        if (now()->gt($user->otp_expired_at)) {
            return back()->withErrors(['otp' => 'OTP expired']);
        }

        // ✅ LOGIN
        Auth::login($user);

        // 🧹 CLEAR OTP
        $user->update([
            'otp' => null,
            'otp_expired_at' => null,
        ]);

        session()->forget('otp_user_id');

        return redirect('/admin');
    }
}