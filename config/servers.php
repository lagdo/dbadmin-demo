<?php

return [
    'common' => [
        'access' => [
            'server' => true,
            'system' => false,
        ],
        'default' => 'dbadmin-pgsql-14',
    ],
    'fallback' => [
        'servers' => [
            // The database servers
            'dbadmin-pgsql-14' => [ // A unique identifier for this server
                'driver' => 'pgsql',
                'name' => 'PostgreSQL 14',     // The name to be displayed in the dashboard UI.
                'host' => 'pgsql.addr',  // The database host name or address.
                'port' => 5433,      // The database port. Optional.
                // 'username' => 'postgres', // The database user credentials.
                // 'password' => 'dbadmin', // The database user credentials.
            ],
            'dbadmin-pgsql-17' => [ // A unique identifier for this server
                'driver' => 'pgsql',
                'name' => 'PostgreSQL 17',     // The name to be displayed in the dashboard UI.
                'host' => 'pgsql.addr',  // The database host name or address.
                'port' => 5434,      // The database port. Optional.
                // 'username' => 'postgres', // The database user credentials.
                // 'password' => 'dbadmin', // The database user credentials.
            ],
            'dbadmin-mariadb' => [ // A unique identifier for this server
                'driver' => 'mysql',
                // 'prefer_pdo' => true,
                'name' => 'MariaDB 10',     // The name to be displayed in the dashboard UI.
                'host' => 'maria.addr',     // The database host name or address.
                'port' => 3307,      // The database port. Optional.
                // 'username' => 'root', // The database user credentials.
                // 'password' => 'dbadmin', // The database user credentials.
            ],
            'dbadmin-mysql' => [ // A unique identifier for this server
                'driver' => 'mysql',
                'name' => 'MySQL 8',     // The name to be displayed in the dashboard UI.
                'host' => 'mysql.addr',     // The database host name or address.
                'port' => 3308,      // The database port. Optional.
                // 'username' => 'root', // The database user credentials.
                // 'password' => 'dbadmin', // The database user credentials.
            ],
            'sqlite-3' => [ // A unique identifier for this server/var/www
                'driver' => 'sqlite',
                'name' => 'Sqlite 3',     // The name to be displayed in the dashboard UI.
                'directory' => '/var/lib/sqlite/3', // The directory containing the database files.
            ],
        ],
    ],
];
