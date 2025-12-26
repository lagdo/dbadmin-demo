<?php

use Lagdo\DbAdmin\Db\DbAuditPackage;
use Lagdo\DbAdmin\Demo\Log\Logger;
use Psr\Log\LoggerInterface;

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
                LoggerInterface::class => fn() => new Logger("$appDir/logs/dbaudit"),
            ],
        ],
        'assets' => [
            'export' => true,
            'minify' => true,
            'uri' => '/jaxon/audit',
            'dir' => "$appDir/public/jaxon/audit",
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
                'uri' => 'https://cdn.jsdelivr.net/gh/jaxon-php/jaxon-js@5.1.0/dist',
            ],
        ],
    ],
];
