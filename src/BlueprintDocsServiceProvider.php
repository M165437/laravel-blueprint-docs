<?php

namespace M165437\BlueprintDocs;

use Illuminate\Support\ServiceProvider;
use Hmaus\DrafterPhp\Drafter;

class BlueprintDocsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'blueprintdocs');

        if (config('blueprintdocs.route')) {
            $this->loadRoutesFrom(__DIR__ . '/routes.php');
        }

        $this->definePublishes();
    }

    /**
     * Define publishable files.
     *
     * @return void
     */
    private function definePublishes()
    {
        $this->publishes([
            __DIR__.'/../config/blueprintdocs.php' => config_path('blueprintdocs.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/blueprintdocs'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/blueprintdocs'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../example.apib' => base_path('blueprint.apib'),
        ], 'example');
    }

    /**
     * Register the package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDrafter();

        $this->registerParsedown();

        $this->registerConfiguration();
    }

    /**
     * Register Drafter.
     *
     * @return void
     */
    private function registerDrafter()
    {
        $this->app->singleton(Drafter::class, function () {
            $drafterBinary = config('blueprintdocs.drafter');
            return new Drafter($drafterBinary);
        });
    }

    /**
     * Register Parsedown.
     *
     * @return void
     */
    private function registerParsedown()
    {
        $this->app->singleton(Parsedown::class);
    }

    /**
     * Register configuration
     *
     * @return void
     */
    public function registerConfiguration()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/blueprintdocs.php', 'blueprintdocs'
        );
    }
}
