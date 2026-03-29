<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Menu;

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
        // Share menu data with all views
        View::composer('layouts.app', function ($view) {
            $menuItems = Menu::where('is_active', true)
                ->whereNull('parent_id')
                ->with('children')
                ->orderBy('order')
                ->get();
            
            $view->with('menuItems', $menuItems);
        });
    }
}
