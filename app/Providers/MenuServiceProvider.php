<?php

namespace App\Providers;

use App\Models\Menus;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('*', function ($view) {
            try {
                if (Schema::hasTable('menus')) {
                    $data = Menus::orderBy('order', 'asc')->where('status', 'active')->get();
                    $view->with('menu', (object) $data);
                } else {
                    $view->with('menu', (object) []);
                }
            } catch (\Exception $e) {
                $view->with('menu', (object) []);
            }
        });
    }
}