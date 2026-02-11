<?php

use Jaxon\Di\Container;
use Lagdo\DbAdmin\Db\Config\AuthInterface;
use Lagdo\DbAdmin\Db\Config\InfisicalConfigReader;
use Lagdo\DbAdmin\Db\Config\UserFileReader;
use Lagdo\DbAdmin\Db\DbAdminPackage;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;

use function Jaxon\storage;

$appDir = dirname(__DIR__);

function getExportStorage(): Filesystem
{
    // Make a Filesystem object with the storage.exports options.
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
        return getenv($name) ?? $default;
    }
}

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
                AuthInterface::class => fn() => new class implements AuthInterface {
                    public function user(): string
                    {
                        return env('DBADMIN_USER', '');
                    }
                    public function role(): string
                    {
                        return env('DBADMIN_ROLE', '');
                    }
                },
            ],
            'extend' => [
                InfisicalConfigReader::class => function(InfisicalConfigReader $reader) {
                    $secretKeyBuilder = fn(string $prefix, string $option) =>
                        "users.{$prefix}.{$option}";
                    $reader->setSecretKeyBuilder($secretKeyBuilder);
                    return $reader;
                },
            ],
        ],
        'assets' => [
            'export' => false,
            'minify' => false,
            'uri' => '/jaxon/admin',
            'dir' => "$appDir/public/jaxon/admin",
            // 'file' => '',
        ],
        'dialogs' => [
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'sweetalert',
                'confirm' => 'sweetalert',
            ],
            'lib' => [
                'use' => ['notyf'],
            ],
        ],
        'storage' => [
            'stores' => [
                'uploads' => [
                    'adapter' => 'local',
                    'dir' => "$appDir/uploads",
                ],
                'exports' => [
                    'adapter' => 'local',
                    'dir' => "$appDir/exports",
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
                'toast' => [
                    'lib' => 'notyf',
                ],
                'provider' => function(array $options, Container $di) {
                    $cfgFilePath = __DIR__ . '/servers.php';
                    $reader = $di->g(UserFileReader::class);
                    return $reader->config($cfgFilePath)->getOptions($options);
                },
                'config' => [
                    'reader' => InfisicalConfigReader::class,
                ],
                'access' => [
                    'server' => false,
                    'system' => false,
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
                'audit' => [
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
        ],
    ],
];
