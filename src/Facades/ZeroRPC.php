<?php
namespace Juwai\LaravelZeroRPC\Facades;

use Illuminate\Support\Facades\Facade;

class ZeroRPC extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'ZeroRPC';
    }
}
