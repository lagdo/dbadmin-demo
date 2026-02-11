<?php

use Lagdo\DbAdmin\Db\DbAuditPackage;

$baseDir = base_dir();

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => false,
                'dir' => "$baseDir/cache/dbaudit/attributes",
            ],
        ],
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'views' => [
            'tpl' => [
                'directory' => "$baseDir/views",
                'extension' => '.php',
                'renderer' => 'jaxon',
            ],
        ],
        'assets' => [
            'export' => false,
            'minify' => false,
            'uri' => '/jaxon/audit',
            'dir' => "$baseDir/public/jaxon/audit",
            // 'file' => '',
        ],
        'packages' => [
            DbAuditPackage::class => [
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
                'alert' => 'sweetalert',
                'confirm' => 'sweetalert',
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'debug' => [
                'on' => false,
            ],
            'request' => [
                'uri' => 'ajax.php?page=audit',
            ],
            'prefix' => [
                'class' => '',
            ],
        ],
        'js' => [
            'lib' => [
                // 'uri' => '',
            ],
        ],
    ],
];
