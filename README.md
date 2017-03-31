# laravel-zerorpc

This package provides an easy way of connecting to
[zerorpc](http://www.zerorpc.io/) from a Laravel application. It uses the
[PHP zerorpc](https://github.com/0rpc/zerorpc-php) client.

## Installation

1. Add facade and providers to `config/app.php`

    ```php
    'aliases' => [
        ...
        'ZeroRPC' => Juwai\LaravelZeroRPC\Facades\ZeroRPC::class,
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

**Known Issue:**

Some times the results are messed up after timeout. Example:
```
$client = RPC::get('service_one', '1.0');

$client->functionA(); // Timeout
$client->functionA(); // Try again, succeed
$client->functionB(); // Return the result of first call

```
**Solution**:

Don't reuse the RPC connection after timeout by destroying the client.
```
RPC::destroyClient('service_one', '1.0');
```
