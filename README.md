# laravel-zerorpc

This package provides an easy way connecting to
[ZeroRPC](https://github.com/0rpc/zerorpc-php) from a Laravel application.

## Installation

1. Add facade and providers to `config/app.php`

    ```php
    'aliases' => [
        ...
        'RPC' => Juwai\LaravelZeroRPC\Facades\ZeroRPC::class,
    ],
    ```

    ```php
    'providers' => [
        ...
        Juwai\LaravelZeroRPC\Providers\ZeroRPCContextProvider::class,
        Juwai\LaravelZeroRPC\Providers\ZeroRPCClientProvider::class,
    ],
    ```

1. Publish config file:

    ```bash
    $ php artisan vendor:publish
    ```

1. Add real service configuration to the published config file
`config/zerorpc.php`.

## Usage

```php
$client = RPC::get('service_one', '1.0');
$response = $client->service_function($param1, $param2);
```
