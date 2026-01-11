<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
      public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            $categories = Category::whereNull('parent_id')
                ->with('children')
                ->orderBy('name')
                ->get();

            $view->with('categories', $categories);
        });
    }
}
