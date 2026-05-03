<?php
namespace FutureX\AppPage;

use Illuminate\Support\ServiceProvider;
class AppPageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/app-page.php',
            'app-page'
        );

        $this->app->register(
            \FutureX\AppPage\Filament\AppPagePanelProvider::class
        );

    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(
            __DIR__.'/../resources/views',
            'app-page'
        );

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // publish config
        $this->publishes([
            __DIR__.'/../config/app-page.php' => config_path('app-page.php'),
        ], 'app-page-config');

        // publish views
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/app-page'),
        ], 'app-page-views');
    }
}
