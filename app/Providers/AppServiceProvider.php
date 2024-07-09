<?php

namespace App\Providers;

use App\Models\Header;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Vite::macro('image', fn (string $asset) => $this->asset("resources/images/{$asset}"));
        if (Schema::hasTable('headers')) {
            View::share(
                'headers',
                Header::orderBy('rank')->get() ?? []
            );
        }
    }
}
