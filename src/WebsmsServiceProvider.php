<?php

namespace LaravelTool\LaravelWebsmsRu;

use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class WebsmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerPublishes();
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/websms_ru.php', 'websms_ru');

        Notification::resolved(function (ChannelManager $manager) {
            $manager->extend('websms_ru', function () {
                return new WebsmsChannel(
                    $this->app['config']['websms_ru.username'],
                    $this->app['config']['websms_ru.password'],
                    $this->app['config']['websms_ru.test_mode'],
                    $this->app['config']['websms_ru.default_sender'],
                );
            });
        });
    }

    protected function registerPublishes(): void
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/websms_ru.php' => config_path('websms_ru.php'),
        ], 'config');
    }
}
