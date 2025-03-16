<?php

namespace App\Providers;

use App\Models\Menus;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $data = Menus::orderBy('order', 'asc')->where('status', 'active')->get();
        View::share('menu', (object) $data);
    }
}
