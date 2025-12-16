<?php

use Jaxon\Storage\StorageManager;
use Lagdo\DbAdmin\Db\Config\AuthInterface;
use Lagdo\DbAdmin\Db\Config\UserFileReader;
use Lagdo\DbAdmin\Db\DbAdminPackage;
use Lagdo\DbAdmin\Demo\Log\Logger;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;
use Psr\Log\LoggerInterface;

$appDir = dirname(__DIR__);

function getExportStorage(): Filesystem
{
    // Make a Filesystem object with the storage.exports options.
    return jaxon()->di()->g(StorageManager::class)->get('exports');
}

function getExportPath(string $filename): string
{
    return "users/$filename";
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
                LoggerInterface::class => fn() => new Logger("$appDir/logs/dbadmin"),
                AuthInterface::class => fn() => new class implements AuthInterface {
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
        'dialogs' => [
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'toastr',
                'confirm' => 'noty',
            ],
        ],
        'storage' => [
            'uploads' => [
                'adapter' => 'local',
                'dir' => "$appDir/uploads",
            ],
            'exports' => [
                'adapter' => 'local',
                'dir' => "$appDir/exports",
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
                'provider' => function(array $options) {
                    $cfgFilePath = __DIR__ . '/config.php';
                    $reader = jaxon()->di()->g(UserFileReader::class);
                    return $reader->getOptions($cfgFilePath, $options);
                },
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
