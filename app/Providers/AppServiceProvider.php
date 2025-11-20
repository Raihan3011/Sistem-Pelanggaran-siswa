<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Models\Siswa;

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
        // Route model binding untuk Siswa
        Route::model('siswa', Siswa::class);
        Route::bind('siswa_id', function ($value) {
            return Siswa::where('siswa_id', $value)->firstOrFail();
        });
    }
}
