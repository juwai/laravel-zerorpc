<?php
namespace Juwai\LaravelZeroRPC\Providers;

use Illuminate\Support\ServiceProvider;
use ZeroRPC\Hook\ConfigMiddleware;
use ZeroRPC\Context;

class ZeroRPCContextProvider extends ServiceProvider
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
        $this->publishes([
            __DIR__ . '/../../config/zerorpc.php' => config_path('zerorpc.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Juwai\LaravelZeroRPC\Context', function ($app) {
            $context = new Context();
            $middleware = new ConfigMiddleware(config('zerorpc'));

            $context->registerHook(
                'resolve_endpoint',
                $middleware->resolveEndpoint()
            );
            $context->registerHook(
                'before_send_request',
                $middleware->beforeSendRequest()
            );

            return $context;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['Juwai\LaravelZeroRPC\Context'];
    }
}
