<?php
namespace Juwai\LaravelZeroRPC\Services;

use Juwai\LaravelZeroRPC\Services\LazyClientWrapper;

class ZeroRPCFactory
{
    private static $_clients = [];

    public function __construct()
    {
        $this->context = app('Juwai\LaravelZeroRPC\Context');
    }

    public function get($serviceName, $version, $timeout = null, $context = null)
    {
        $key = $serviceName . $version . $timeout;
        if (array_key_exists($key, self::$_clients)) {
            return self::$_clients[$key];
        }

        $context = $context ?: $this->context;

        $client = new LazyClientWrapper(
            $serviceName,
            $version,
            $context,
            $timeout
        );

        self::$_clients[$key] = $client;

        return $client;
    }

    public function destroyClient($serviceName, $version, $timeout = null)
    {
        $key = $serviceName . $version . $timeout;
        unset(self::$_clients[$key]);
    }
}
