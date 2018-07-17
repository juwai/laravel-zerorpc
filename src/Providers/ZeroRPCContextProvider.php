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
            __DIR__ . '/../../config/zerorpc.php' => base_path('config' . DIRECTORY_SEPARATOR . 'zerorpc.php'),
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

            if ($this->app->has('Barryvdh\Debugbar\LaravelDebugbar')) {
                $context->registerHook(
                    'before_send_request',
                    $this->debugbarStartMeasure()
                );
                $context->registerHook(
                    'after_response',
                    $this->debugbarStopMeasure()
                );
            }

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

    /**
     * Debugbar start measure callback.
     *
     * @return function
     */
    private function debugbarStartMeasure()
    {
        return function ($event, $client) {
            start_measure(
                $event->header['message_id'],
                'RPC: ' . $event->name
            );
            debug('RPC: ' . $event->name . ' ' . json_encode($event->args));
        };
    }

    /**
     * Debugbar stop measure callback.
     *
     * @return function
     */
    private function debugbarStopMeasure()
    {
        return function ($event, $client) {
            stop_measure($event->header['response_to']);
        };
    }
}
