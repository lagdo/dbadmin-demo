<?php

return [
    'common' => [
        'access' => [
            'server' => false,
            'system' => false,
        ],
    ],
    'fallback' => [
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
];
