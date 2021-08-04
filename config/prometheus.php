<?php

return [
    'namespace' => env('PROMETHEUS_NAMESPACE', 'app'),

    'metrics_route' => '/metrics',

    'enable_route_middleware' => true,

    'storage_adapter' => env('PROMETHEUS_STORAGE_ADAPTER', 'memory'),

    'push_gateway' => [
        'enabled' => env('PROMETHEUS_USE_PUSH_GATEWAY', false),
        'url' => env('PROMETHEUS_PUSH_GATEWAY_URL', 'http://127.0.0.1:9091'),
        'job' => env('PROMETHEUS_PUSH_GATEWAY_JOB_NAME', ''),
    ],

    'redis' => [
        'host' => env('PROMETHEUS_REDIS_HOST', '127.0.0.1'),
        'port' => env('PROMETHEUS_REDIS_PORT', 6379),
        'password' => env('PROMETHEUS_REDIS_PASSWORD'),
        'timeout' => 0.1,
        'read_timeout' => '10',
        'persistent_connections' => false,
    ],
];
