<?php

use Lagdo\DbAdmin\Config\UserFileReader;

$appDir = dirname(__DIR__);

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => false,
                'dir' => "$appDir/cache/dbadmin/attributes",
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
                Psr\Log\LoggerInterface::class => fn() =>
                    new Lagdo\DbAdmin\Demo\Log\Logger("$appDir/logs/dbadmin"),
                Lagdo\DbAdmin\Config\AuthInterface::class => fn() =>
                    new class implements Lagdo\DbAdmin\Config\AuthInterface {
                        public function user(): string
                        {
                            return '';
                        }
                        public function role(): string
                        {
                            return '';
                        }
                    },
            ],
        ],
        'packages' => [
            Lagdo\DbAdmin\DbAdminPackage::class => [
                'provider' => function(array $options) {
                    $cfgFilePath = __DIR__ . '/config.php';
                    $reader = jaxon()->di()->g(UserFileReader::class);
                    return $reader->getOptions($cfgFilePath, $options);
                },
                'export' => [
                    'writer' => fn(string $content, string $filename): bool|int =>
                        @file_put_contents("$appDir/exports/user/$filename", "$content\n"),
                    'reader' => function(string $filename) use($appDir): string {
                        $exportDir = "$appDir/exports/user";
                        $filepath = "$exportDir/$filename";
                        return !is_dir($exportDir) || !is_file($filepath) ?
                            "No file $filepath found." : file_get_contents($filepath);
                    },
                    'url' => fn(string $filename): string => "/export.php?file=$filename",
                ],
                'access' => [
                    'server' => false,
                    'system' => false,
                ],
                'logging' => [
                    'options' => [
                        'library' => [
                            'enabled' => false,
                        ],
                        'enduser' => [
                            'enabled' => true,
                        ],
                        'history' => [
                            'enabled' => true,
                            'distinct' => true,
                            'limit' => 10,
                        ],
                        'favorite' => [
                            'enabled' => true,
                            'limit' => 10,
                        ],
                    ],
                    'database' => [
                        // Same as the "servers" items, but "name" is the database name.
                        'driver' => 'sqlite',
                        'directory' => '/var/lib/sqlite/3',
                        'name' => 'chinook.db',
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
                'dir' => "$appDir/public/jaxon",
                // 'file' => '',
            ],
        ],
    ],
];
