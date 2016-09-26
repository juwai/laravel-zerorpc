<?php
namespace Juwai\LaravelZeroRPC\Providers;

use Illuminate\Support\ServiceProvider;

use Juwai\LaravelZeroRPC\Services\ZeroRPCFactory;

class ZeroRPCClientProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ZeroRPC', function ($app) {
            return new ZeroRPCFactory();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['ZeroRPC'];
    }
}
