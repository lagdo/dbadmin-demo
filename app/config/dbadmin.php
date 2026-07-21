<?php

require_once dirname(__DIR__) . '/lib.php';

use Jaxon\Di\Container;
use Lagdo\DbAdmin\App\DbAdminPackage;
use Lagdo\DbAdmin\Support\Provider;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;

use function Jaxon\storage;

$baseDir = base_dir();
$secrets = include  __DIR__ . '/secrets.php';
$foreigns = include  __DIR__ . '/foreigns.php';

function getExportStorage(): Filesystem
{
    // Make a Filesystem object with the storage.stores.exports options.
    return storage()->get('exports');
}

function getExportPath(string $filename): string
{
    return "users/$filename";
}

if (!function_exists('env'))
{
    function env(string $name, mixed $default = null): mixed
    {
        return getenv($name) ?: $default;
    }
}

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => false,
                'dir' => "$baseDir/cache/dbadmin/attributes",
            ],
        ],
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'views' => [
            'tpl' => [
                'directory' => "$baseDir/views/bootstrap5",
                'extension' => '.php',
                'renderer' => 'jaxon',
            ],
        ],
        'container' => [
            'set' => [
                Provider\AuthInterface::class => $secrets['auth'],
            ],
            'extend' => $secrets['container']['extend'],
        ],
        'assets' => [
            'export' => false,
            'minify' => false,
            'uri' => '/jaxon/admin',
            'dir' => "$baseDir/public/jaxon/admin",
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
        'packages' => [
            DbAdminPackage::class => [
                'ui' => [
                    'toast' => [
                        'lib' => 'butterup',
                    ],
                    'query' => [
                        'editor' => 'cm', // 'cm' for CodeMirror or 'ace' for Ace Editor.
                    ],
                ],
                'assets' => [
                    'url' => '/assets',
                ],
                'provider' => function(array $options, Container $di) {
                    $cfgFilePath = __DIR__ . '/servers.php';
                    $provider = $di->g(Provider\PackageConfigProvider::class);
                    return $provider->config($cfgFilePath)->getOptions($options);
                },
                'reader' => [
                    'server' => Provider\Config\ServerConfigProvider::class,
                    'secret' => $secrets['reader'],
                ],
                'export' => [
                    'writer' => function(string $content, string $filename): string {
                        try {
                            $storage = getExportStorage();
                            $storage->write(getExportPath($filename), "$content\n");
                        } catch (FilesystemException|UnableToWriteFile) {
                            return '';
                        }
                        // Return the link to the exported file.
                        return "/export.php?file=$filename";
                    },
                    'reader' => function(string $filename): string {
                        try {
                            $storage = getExportStorage();
                            $filepath = getExportPath($filename);
                            return !$storage->fileExists($filepath) ?
                                "No file $filename found." : $storage->read($filepath);
                        } catch (FilesystemException|UnableToReadFile) {
                            return "No file $filename found.";
                        }
                    },
                ],
                'queries' => [
                    'record' => [
                        'library' => [
                            'enabled' => false,
                        ],
                        'builder' => [
                            'enabled' => true,
                        ],
                        'editor' => [
                            'enabled' => true,
                        ],
                    ],
                    'admin' => [
                        'history' => [
                            'show' => true,
                            'distinct' => true,
                            'limit' => 10,
                        ],
                        'favorite' => [
                            'show' => true,
                            'limit' => 10,
                        ],
                        'preferences' => [
                            'enabled' => true,
                        ],
                    ],
                    'database' => [
                        // Same as the "servers" items, but "name" is the database name.
                        'driver' => 'sqlite',
                        'directory' => '/var/lib/sqlite/3',
                        'name' => 'chinook.db',
                    ],
                ],
                // The SQL SELECT clauses to get labels for foreign key columns.
                'foreigns' => $foreigns,
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
                'uri' => '/assets/jaxon',
            ],
        ],
    ],
];
