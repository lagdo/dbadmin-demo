<?php

return [
    'app' => [
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'container' => [
            'set' => [
                Psr\Log\LoggerInterface::class => function() {
                    $logFilePath = '/var/www/dbadmin-demo/logs/dbadmin';
                    return new Lagdo\DbAdmin\Demo\Log\Logger($logFilePath);
                },
            ],
        ],
        'packages' => [
            Lagdo\DbAdmin\Package::class => [
                'servers' => [
                    // The database servers
                    'db-postgresql' => [ // A unique identifier for this server
                        'driver' => 'pgsql',
                        'name' => 'PostgreSQL 14',     // The name to be displayed in the dashboard UI.
                        'host' => 'db-postgresql',     // The database host name or address.
                        'port' => 5432,      // The database port. Optional.
                        'username' => 'postgres', // The database user credentials.
                        'password' => 'dbadmin', // The database user credentials.
                    ],
                    'db-mariadb' => [ // A unique identifier for this server
                        'driver' => 'mysql',
                        'name' => 'MariaDB 10',     // The name to be displayed in the dashboard UI.
                        'host' => 'db-mariadb',     // The database host name or address.
                        'port' => 3306,      // The database port. Optional.
                        'username' => 'root', // The database user credentials.
                        'password' => 'dbadmin', // The database user credentials.
                    ],
                    'db-mysql' => [ // A unique identifier for this server
                        'driver' => 'mysql',
                        'name' => 'MySQL 8',     // The name to be displayed in the dashboard UI.
                        'host' => 'db-mysql',     // The database host name or address.
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
