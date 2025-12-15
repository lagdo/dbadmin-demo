<?php

use Lagdo\DbAdmin\Demo\Log\Logger;

$appDir = dirname(__DIR__);

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => false,
                'dir' => "$appDir/cache/dbaudit/attributes",
            ],
        ],
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'views' => [
            'tpl' => [
                'directory' => "$appDir/views",
                'extension' => '.php',
                'renderer' => 'jaxon',
            ],
        ],
        'container' => [
            'set' => [
                Psr\Log\LoggerInterface::class => fn() => new Logger("$appDir/logs/dbaudit"),
            ],
        ],
        'packages' => [
            Lagdo\DbAdmin\Db\DbAuditPackage::class => [
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
            'app' => [
                'export' => false,
                'minify' => false,
                'uri' => '/jaxon',
                'dir' => "$appDir/public/jaxon",
                // 'file' => '',
            ],
        ],
    ],
];
