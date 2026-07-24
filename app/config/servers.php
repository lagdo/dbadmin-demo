<?php

return [
    'common' => [
        'access' => [
            'server' => true,
            'system' => false,
        ],
    ],
    'fallback' => [
        'default' => 'dbadmin-pgsql-14',
        'servers' => [
            // The database servers
            'dbadmin-pgsql-14' => [
                'driver' => 'pgsql',
                'name' => 'PostgreSQL 14',
                'host' => env('PGSQL14_DB_HOST'),
                'port' => env('PGSQL14_DB_PORT'),
                'username' => env('PGSQL14_DB_USERNAME'),
                'password' => env('PGSQL14_DB_PASSWORD'),
            ],
            'dbadmin-pgsql-17' => [
                'driver' => 'pgsql',
                'name' => 'PostgreSQL 17',
                'host' => env('PGSQL17_DB_HOST'),
                'port' => env('PGSQL17_DB_PORT'),
                'username' => env('PGSQL17_DB_USERNAME'),
                'password' => env('PGSQL17_DB_PASSWORD'),
            ],
            'dbadmin-mariadb' => [
                'driver' => 'mysql',
                // 'prefer_pdo' => true,
                'name' => 'MariaDB 10',
                'host' => env('MARIA_DB_HOST'),
                'port' => env('MARIA_DB_PORT'),
                'username' => env('MARIA_DB_USERNAME'),
                'password' => env('MARIA_DB_PASSWORD'),
            ],
            'dbadmin-mysql' => [
                'driver' => 'mysql',
                'name' => 'MySQL 8',
                'host' => env('MYSQL_DB_HOST'),
                'port' => env('MYSQL_DB_PORT'),
                'username' => env('MYSQL_DB_USERNAME'),
                'password' => env('MYSQL_DB_PASSWORD'),
            ],
            'dbadmin-sqlite3' => [
                'driver' => 'sqlite',
                'name' => 'Sqlite 3',
                'directory' => '/var/lib/sqlite/3',
            ],
        ],
    ],
];
