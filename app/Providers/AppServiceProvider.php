<?php

namespace App\Providers;

use App\Models\Admin\Category;
use App\Observers\AdminCategoryObserver;
use Illuminate\Support\ServiceProvider;
use Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        date_default_timezone_set('Europe/Kiev');
        Category::observe(AdminCategoryObserver::class);
    }
}
