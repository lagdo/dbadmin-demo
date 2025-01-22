<?php

return [
    'app' => [
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'packages' => [
            Lagdo\DbAdmin\Package::class => [
                'servers' => [
                    // The database servers
                    'tontine-pgsql' => [ // A unique identifier for this server
                        'driver' => 'pgsql',
                        'name' => 'Tontine PostgreSQL',     // The name to be displayed in the dashboard UI.
                        'host' => 'db.addr',     // The database host name or address.
                        'port' => 5432,      // The database port. Optional.
                        'username' => 'tontine', // The database user credentials.
                        'password' => 'tontine', // The database user credentials.
                    ],
                    // 'tontine-mysql' => [ // A unique identifier for this server
                    //     'driver' => 'mysql',
                    //     'name' => 'Tontine MySQL',     // The name to be displayed in the dashboard UI.
                    //     'host' => 'db.addr',     // The database host name or address.
                    //     'port' => 3336,      // The database port. Optional.
                    //     'username' => '', // The database user credentials.
                    //     'password' => '', // The database user credentials.
                    // ],
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
                'export' => true,
                'minify' => false,
                'uri' => '/jaxon',
                'dir' => __DIR__ . '/public/jaxon',
                // 'file' => '',
            ],
        ],
    ],
];
