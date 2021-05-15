<?php

namespace OneCoin\StellarSdk;

use Illuminate\Support\ServiceProvider;

class StellarSdkServiceProvider extends ServiceProvider
{
    public function register()
    {
        $configPath = __DIR__ . '/../config/stellarsdk.php';
        $this->mergeConfigFrom($configPath, 'stellarsdk');
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
