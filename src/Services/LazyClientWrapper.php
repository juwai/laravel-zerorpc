<?php
namespace Juwai\LaravelZeroRPC\Services;

/*
 * When a client object is created, the PHP client will immediately connect
 * to the endpoint. This wrapper avoids connecting until there is an actual
 * function call.
 */
class LazyClientWrapper
{
    private $_client = null;
    private $_serviceName;
    private $_version;
    private $_context;
    private $_timeout;

    public function __construct($serviceName, $version, $context, $timeout)
    {
        $this->_serviceName = $serviceName;
        $this->_version = $version;
        $this->_context = $context;
        $this->_timeout = $timeout;
    }

    public function __call($name, $arguments)
    {
        if (is_null($this->_client)) {
            $this->_client = new Client(
                $this->_serviceName,
                $this->_version,
                $this->_context
            );

            if ($this->_timeout == null) {
                $this->_timeout = env('DEFAULT_RPC_TIMEOUT', 1000);
            }

            $this->_client->setTimeout($this->_timeout);
        }

        return call_user_func_array([$this->_client, $name], $arguments);
    }
}