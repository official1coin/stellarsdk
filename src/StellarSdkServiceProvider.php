<?php

namespace OneCoin\StellarSdk;

use Illuminate\Support\ServiceProvider;



class StellarSdkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $configPath = __DIR__ . '/../config/stellarsdk.php';
        $this->mergeConfigFrom($configPath, 'stellarsdk');

        $this->app->singleton(StellarSdk::class, function ($app) {
            if (config('stellar_network') == 'public') {
                return Server::publicNet();
            } elseif (config('stellar_network') == 'test') {
                return Server::testNet();
            } elseif (config('stellar_network') == 'custom') {
                return Server::customNet(config('stellar_custom_network'), 'Public Global Stellar Network ; September 2015');
            }
        });
    }


    public function boot()
    {
        $configPath = __DIR__ . '/../config/stellarsdk.php';
        $this->publishes([$configPath => $this->getConfigPath()], 'config');
    }

    protected function getConfigPath()
    {
        return config_path('stellarsdk.php');
    }

    protected function publishConfig($configPath)
    {
        $this->publishes([$configPath => config_path('stellarsdk.php')], 'config');
    }
}
