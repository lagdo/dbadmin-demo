<?php

require_once dirname(__DIR__) . '/lib.php';

$baseDir = base_dir();

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => false,
                'dir' => "$baseDir/cache/attributes",
            ],
        ],
        'assets' => [
            'export' => false,
            'minify' => false,
            'uri' => '/jaxon/app-0.9.0',
            'dir' => "$baseDir/public/jaxon/app-0.9.0",
            // 'file' => '',
        ],
        'dialogs' => [
            // The dialogs libraries are defined in the dbadmin/services/template.php file.
            'lib' => [
                'use' => ['bootstrap5', 'bulma', 'sweetalert', 'cute', 'notyf'],
            ],
        ],
        'storage' => [
            'stores' => [
                'export_status' => [
                    'adapter' => 'local',
                    'dir' => "$baseDir/exports/status",
                ],
                'import_uploads' => [
                    'adapter' => 'local',
                    'dir' => "$baseDir/imports/uploads",
                ],
                'import_dumps' => [
                    'adapter' => 'local',
                    'dir' => "$baseDir/imports/dumps",
                ],
                'import_status' => [
                    'adapter' => 'local',
                    'dir' => "$baseDir/imports/status",
                ],
                'pgsql_dumps' => [
                    'adapter' => 'local',
                    'dir' => '/var/www/docker/scripts/seeds/pgsql/sql',
                ],
                'mysql_dumps' => [
                    'adapter' => 'local',
                    'dir' => '/var/www/docker/scripts/seeds/mysql/sql',
                ],
            ],
        ],
        'upload' => [
            'enabled' => true,
            'default' => [
                'directory' => "$baseDir/imports/uploads",
                // 'storage' => 'import_uploads',
                'extensions' => ['sql', 'gz', 'gzip', 'bz2', 'bzip2'],
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'debug' => [
                'on' => false,
                'verbose' => false,
            ],
            // 'request' => [
            //     'uri' => '',
            // ],
            'prefix' => [
                'class' => '',
            ],
        ],
        'js' => [
            'lib' => [
                'uri' => '/jaxon/lib-5.2.5',
            ],
        ],
    ],
];
