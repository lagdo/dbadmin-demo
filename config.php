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
                    'postgresql-14' => [ // A unique identifier for this server
                        'driver' => 'pgsql',
                        'name' => 'PostgreSQL 14',     // The name to be displayed in the dashboard UI.
                        'host' => 'postgresql-14',     // The database host name or address.
                        'port' => 5432,      // The database port. Optional.
                        'username' => 'postgres', // The database user credentials.
                        'password' => 'dbadmin', // The database user credentials.
                    ],
                    'mysql-5' => [ // A unique identifier for this server
                        'driver' => 'mysql',
                        'name' => 'MySQL 5',     // The name to be displayed in the dashboard UI.
                        'host' => 'mysql-5',     // The database host name or address.
                        'port' => 3306,      // The database port. Optional.
                        'username' => 'root', // The database user credentials.
                        'password' => 'dbadmin', // The database user credentials.
                    ],
                    'sqlite-3' => [ // A unique identifier for this server/var/www
                        'driver' => 'sqlite',
                        'name' => 'Sqlite 3',     // The name to be displayed in the dashboard UI.
                        'directory' => '/var/lib/sqlite/3', // The directory containing the database files.
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
