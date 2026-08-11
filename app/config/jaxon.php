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
        'template' => [
            'name' => 'bootstrap5',
            'assets' => [
                'url' => '/dbadmin',
            ],
        ],
        'audit' => [
            'enabled' => true,
            'users' => [
                // The emails of users that are allowed to access the audit page.
                'admin@company.com',
            ],
        ],
        'views' => [
            'tpl' => [
                'directory' => "$baseDir/views/bootstrap5",
                'extension' => '.php',
                'renderer' => 'jaxon',
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
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'sweetalert',
                'confirm' => 'sweetalert',
            ],
            'lib' => [
                'use' => ['butterup'],
            ],
        ],
        'storage' => [
            'stores' => [
                'uploads' => [
                    'adapter' => 'local',
                    'dir' => "$baseDir/uploads",
                ],
                'exports' => [
                    'adapter' => 'local',
                    'dir' => "$baseDir/exports",
                ],
            ],
        ],
        'upload' => [
            'enabled' => true,
            'files' => [
                'sql_files' => [
                    'storage' => 'uploads',
                ],
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'debug' => [
                'on' => false,
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
