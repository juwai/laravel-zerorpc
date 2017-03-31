<?php
namespace Juwai\LaravelZeroRPC\Services;

use Log;
use ZeroRPC\Client;

class ZeroRPCFactory
{
    private static $_clients = [];

    public function __construct()
    {
        $this->context = \App::make('Juwai\LaravelZeroRPC\Context');
    }

    public function get($serviceName, $version, $timeout = null, $context = null)
    {
        $key = $serviceName . $version . $timeout;
        if (array_key_exists($key, self::$_clients)) {
            return self::$_clients[$key];
        }

        $context = $context ?: $this->context;
        $client = new Client($serviceName, $version, $context);
        if ($timeout == null) {
            $timeout = env('DEFAULT_RPC_TIMEOUT', 1000);
        }
        $client->setTimeout($timeout);

        self::$_clients[$key] = $client;

        return $client;
    }

    public function destroyClient($serviceName, $version, $timeout = null)
    {
        $key = $serviceName . $version . $timeout;
        unset(self::$_clients[$key]);
    }
}
