<?php

$appDir = dirname(__DIR__);

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => false,
                'dir' => "$appDir/cache/logging/attributes",
            ],
        ],
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'views' => [
            'tpl' => [
                'directory' => "$appDir/views",
                'extension' => '.php',
                'renderer' => 'jaxon',
            ],
        ],
        'container' => [
            'set' => [
                Psr\Log\LoggerInterface::class => function() use($appDir) {
                    $logFilePath = "$appDir/logs/dbadmin";
                    return new Lagdo\DbAdmin\Demo\Log\Logger($logFilePath);
                },
            ],
        ],
        'packages' => [
            Lagdo\DbAdmin\LoggingPackage::class => [
                'database' => [
                    // Same as the "servers" items, but "name" is the database name.
                    'driver' => 'sqlite',
                    'directory' => '/var/lib/sqlite/3',
                    'name' => 'chinook.db',
                ],
            ],
        ],
        'dialogs' => [
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'toastr',
                'confirm' => 'noty',
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'debug' => [
                'on' => false,
            ],
            'request' => [
                'uri' => 'ajax.php?page=log',
            ],
            'prefix' => [
                'class' => '',
            ],
        ],
        'js' => [
            'lib' => [
                // 'uri' => '',
            ],
            'app' => [
                'export' => false,
                'minify' => false,
                'uri' => '/jaxon',
                'dir' => "$appDir/public/jaxon",
                // 'file' => '',
            ],
        ],
    ],
];
