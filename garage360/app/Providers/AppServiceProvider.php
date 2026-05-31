<?php

namespace App\Providers;

use App\Models\Category;
use App\Services\CartService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CartService::class);
    }

    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            try {
                $cartCount = app(CartService::class)->itemCount();
            } catch (\Throwable) {
                $cartCount = 0;
            }

            try {
                $navCategories = Category::with(['children' => fn($q) => $q->where('is_active', true)->orderBy('sort_order')])
                    ->whereNull('parent_id')
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();
            } catch (\Throwable) {
                $navCategories = collect();
            }

            $view->with(compact('cartCount', 'navCategories'));
        });
    }
}
