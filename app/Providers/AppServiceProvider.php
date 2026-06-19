<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // تأكد من إضافة هذا السطر

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // إجبار النظام على استخدام https إذا كان على السيرفر
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
