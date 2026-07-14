<?php

use Jaxon\Di\Container;
use Lagdo\DbAdmin\App\DbAdminPackage;
use Lagdo\DbAdmin\Support\Provider;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;

use function Jaxon\storage;

$baseDir = base_dir();

function getExportStorage(): Filesystem
{
    // Make a Filesystem object with the storage.stores.exports options.
    return storage()->get('exports');
}

function getExportPath(string $filename): string
{
    return "users/$filename";
}

function getInfisicalSecretKey(string $prefix, string $option, Provider\AuthInterface $auth): string
{
    return "users.{$prefix}.{$option}";
}

function getAwsSecretSecretKey(string $prefix, Provider\AuthInterface $auth): string
{
    return "users.{$prefix}";
}

function getGcpSecretSecretKey(string $prefix, string $option, Provider\AuthInterface $auth): string
{
    return "db.users.{$prefix}.{$option}";
}

function getOpenBaoSecretKey(string $prefix, string $option, Provider\AuthInterface $auth): string
{
    // The key is prefixed with "data/", for the KV2 API.
    return "data/db.users.{$prefix}.{$option}";
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
                Provider\AuthInterface::class =>
                    fn() => new class implements Provider\AuthInterface {
                        public function user(): string
                        {
                            return env('DBADMIN_USER', '');
                        }
                        public function name(): string
                        {
                            return env('DBADMIN_NAME', '');
                        }
                        public function role(): string
                        {
                            return env('DBADMIN_ROLE', '');
                        }
                        public function logout(): string
                        {
                            return '/logout';
                        }
                    },
            ],
            'extend' => [
                Provider\Secret\InfisicalConfigProvider::class =>
                    fn(Provider\Secret\InfisicalConfigProvider $provider) =>
                        $provider->setSecretKeyBuilder(getInfisicalSecretKey(...)),
                Provider\Secret\AwsSecretConfigProvider::class =>
                    fn(Provider\Secret\AwsSecretConfigProvider $provider) =>
                        $provider->setSecretKeyBuilder(getAwsSecretSecretKey(...)),
                Provider\Secret\GcpSecretConfigProvider::class =>
                    fn(Provider\Secret\GcpSecretConfigProvider $provider) =>
                        $provider->setSecretKeyBuilder(getGcpSecretSecretKey(...)),
                Provider\Secret\OpenBaoConfigProvider::class =>
                    fn(Provider\Secret\OpenBaoConfigProvider $provider) =>
                        $provider->setSecretKeyBuilder(getOpenBaoSecretKey(...)),
            ],
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
                        'editor' => 'ace', // 'cm' for CodeMirror or 'ace' for Ace Editor.
                    ],
                ],
                'provider' => function(array $options, Container $di) {
                    $cfgFilePath = __DIR__ . '/servers.php';
                    $provider = $di->g(Provider\PackageConfigProvider::class);
                    return $provider->config($cfgFilePath)->getOptions($options);
                },
                'reader' => [
                    'server' => Provider\Config\ServerConfigProvider::class,
                    'secret' => Provider\Secret\AwsSecretConfigProvider::class,
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
                'foreigns' => include  __DIR__ . '/foreigns.php',
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
                'uri' => '/jaxon',
            ],
        ],
    ],
];
