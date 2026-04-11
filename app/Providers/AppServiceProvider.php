<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// ✅ WAJIB IMPORT INI
//use Filament\Http\Responses\Auth\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🔥 override redirect login filament → OTP
       // $this->app->bind(LoginResponseContract::class, LoginResponse::class);
    }
}                                                                                                                                                                                                                                                                                                                                                                                                                                                                                   