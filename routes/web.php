<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 Home
Route::get('/', function () {
    return redirect('/admin/login');
});

// 🔐 OTP PAGE
Route::get('/otp', function () {
    return view('auth.otp');
})->name('otp.form');

// ✅ VERIFY OTP
Route::post('/otp', [OtpController::class, 'verify'])->name('otp.verify');
