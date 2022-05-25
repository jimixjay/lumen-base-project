<?php

use Monolog\Handler\StreamHandler;

$outputStream = (env('LOG_OUTPUT') == 'stream');
$driver       = $outputStream ? 'monolog' : 'daily';
$formatter    = $outputStream ? Monolog\Formatter\JsonFormatter::class : null;

return [

    'default' => env('LOG_CHANNEL', 'stack'),

    'channels' => [

        'stack' => [
            'driver'   => 'stack',
            'channels' => ['error', 'debug'],
        ],

        'error' => [
            'name'      => 'error',
            'level'     => 'error',
            'bubble'    => false,
            'handler'   => StreamHandler::class,
            'driver'    => $driver,
            'formatter' => $formatter,
            'path'      => $outputStream ? null : storage_path('logs/error.log'),
            'with'      => [
                'stream' => 'php://stderr',
            ],
        ],

        'debug' => [
            'name'      => 'debug',
            'level'     => 'debug',
            'bubble'    => false,
            'handler'   => StreamHandler::class,
            'driver'    => $driver,
            'formatter' => $formatter,
            'path'      => $outputStream ? null : storage_path('logs/debug.log'),
            'with'      => [
                'stream' => 'php://stdout',
            ],
        ],

        'api_input_output' => [
            'name'      => 'api_input_output',
            'level'     => 'debug',
            'bubble'    => false,
            'handler'   => StreamHandler::class,
            'driver'    => 'monolog',
            'formatter' => \Monolog\Formatter\JsonFormatter::class,
            'path'      => null,
            'with'      => [
                'stream' => 'php://stdout',
            ],
        ],

        'access' => [
            'name'      => 'access',
            'level'     => 'info',
            'bubble'    => false,
            'handler'   => StreamHandler::class,
            'driver'    => $driver,
            'formatter' => $formatter,
            'path'      => $outputStream ? null : storage_path('logs/access.log'),
            'with'      => [
                'stream' => 'php://stdout',
            ],
        ],

        'debug_status' => [
            'name'      => 'debug_status',
            'level'     => 'debug',
            'bubble'    => false,
            'handler'   => StreamHandler::class,
            'driver'    => $driver,
            'formatter' => $formatter,
            'path'       => $outputStream ? null : storage_path('logs/debug_status.log'),
            'with'      => [
                'stream' => 'php://stdout',
            ],
        ],

        'api_complete_log_channel' => [
            'name'      => 'api_complete_log_channel',
            'level'     => 'debug',
            'bubble'    => false,
            'handler'   => StreamHandler::class,
            'driver'    => $driver,
            'formatter' => $formatter,
            'path'      => $outputStream ? null : storage_path('logs/apicomplete/api.log'),
            'with'      => [
                'stream' => 'php://stdout',
            ],
        ],

        'default_guzzle_client' => [
            'name'      => 'default_guzzle_client',
            'level'     => 'debug',
            'bubble'    => false,
            'handler'   => StreamHandler::class,
            'driver'    => $driver,
            'formatter' => $formatter,
            'path'      => $outputStream ? null : storage_path('logs/default_guzzle_client.log'),
            'with'      => [
                'stream' => 'php://stdout',
            ],
        ],

    ],

];
