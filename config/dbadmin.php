<?php

use Infisical\SDK\InfisicalSDK;
use Jaxon\Di\Container;
use Lagdo\DbAdmin\Db\Config\AuthInterface;
use Lagdo\DbAdmin\Db\Config\UserFileReader;
use Lagdo\DbAdmin\Db\DbAdminPackage;
use Lagdo\DbAdmin\Demo\Config\InfisicalConfigReader;
use Lagdo\DbAdmin\Demo\Log\Logger;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;
use Psr\Log\LoggerInterface;

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
                        return getenv('DBADMIN_USER') ?: '';
                    }
                    public function role(): string
                    {
                        return getenv('DBADMIN_ROLE') ?: '';
                    }
                },
                InfisicalConfigReader::class => function(Container $di) {
                    $auth = $di->g(AuthInterface::class);

                    $infisicalSdk = new InfisicalSDK(getenv('INFISICAL_SERVER_URL'));
                    $clientId = getenv('INFISICAL_MACHINE_CLIENT_ID');
                    $clientSecret = getenv('INFISICAL_MACHINE_CLIENT_SECRET');
                    // Authenticate on the Infisical server.
                    $infisicalSdk->auth()->universalAuth()->login($clientId, $clientSecret);
                    // Create the Infisical secrets service.
                    $secrets = $infisicalSdk->secrets();
                    $projectId = getenv('INFISICAL_PROJECT_ID');
                    return new InfisicalConfigReader($auth, $secrets, $projectId, 'dev');
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
                'provider' => function(array $options) {
                    $cfgFilePath = __DIR__ . '/servers.php';
                    $reader = jaxon()->di()->g(UserFileReader::class);
                    return $reader->getOptions($cfgFilePath, $options);
                },
                'config' => [
                    'reader' => Lagdo\DbAdmin\Demo\Config\InfisicalConfigReader::class,
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
