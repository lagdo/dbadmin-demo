<?php

use Lagdo\DbAdmin\Config\UserFileReader;

return [
    'app' => [
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'container' => [
            'set' => [
                Psr\Log\LoggerInterface::class => function() {
                    $logFilePath = __DIR__ . '/logs/dbadmin';
                    return new Lagdo\DbAdmin\Demo\Log\Logger($logFilePath);
                },
            ],
        ],
        'packages' => [
            Lagdo\DbAdmin\DbAdminPackage::class => [
                'provider' => function(array $options) {
                    $cfgFilePath = __DIR__ . '/config.php';
                    $reader = jaxon()->di()->g(UserFileReader::class);
                    return $reader->getOptions($cfgFilePath, $options);
                },
                'access' => [
                    'server' => false,
                    'system' => false,
                ],
                'logging' => [
                    'options' => [
                        'library' => [
                            'enabled' => false,
                        ],
                        'enduser' => [
                            'enabled' => true,
                        ],
                        'history' => [
                            'enabled' => true,
                            'distinct' => true,
                            'limit' => 10,
                        ],
                    ],
                    'database' => [
                        // Same as the "servers" items, but "name" is the database name.
                        'driver' => 'sqlite',
                        'directory' => '/var/lib/sqlite/3',
                        'name' => 'chinook.db',
                    ],
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
                'uri' => 'ajax.php',
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
                'dir' => __DIR__ . '/public/jaxon',
                // 'file' => '',
            ],
        ],
    ],
];
