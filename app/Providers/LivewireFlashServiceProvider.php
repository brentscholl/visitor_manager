<?php

namespace App\Providers;

use App\Notifications\FlashMessages\LaravelSessionStore;
use App\Notifications\FlashMessages\LivewireFlashNotifier;
use App\Notifications\FlashMessages\SessionStore;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireFlashServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            SessionStore::class,
            LaravelSessionStore::class
        );

        $this->app->singleton('lwflash', function ($app) {
            return $app->make(LivewireFlashNotifier::class); // Use the actual class name here
        });
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
//        Livewire::component('flash-container', \App\Livewire\FlashContainer::class);
//        Livewire::component('flash-message', \App\Livewire\FlashMessage::class);
//        Livewire::component('flash-overlay', \App\Livewire\FlashOverlay::class);
    }
}
