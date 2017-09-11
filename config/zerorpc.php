<?php

return [
    'ZERORPC_SERVICE_ONE' => [
        '1.0'        => env('RPC_SERVICE_ONE_ENDPOINT'),
        '2.0'        => env('RPC_SERVICE_ONE_ENDPOINT'),
        'access_key' => env('RPC_SERVICE_ONE_ACCESS_KEY'),
        'default'    => env('RPC_SERVICE_ONE_VERSION'),
    ],
    'ZERORPC_SERVICE_TWO' => [
        '1.0'        => env('RPC_SERVICE_TWO_ENDPOINT'),
        'access_key' => env('RPC_SERVICE_TWO_ACCESS_KEY'),
        'default'    => env('RPC_SERVICE_TWO_VERSION'),
    ],
];
