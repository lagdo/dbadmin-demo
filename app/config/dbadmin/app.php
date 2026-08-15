<?php

use Lagdo\DbAdmin\Support\Facade\Auth;
use Lagdo\DbAdmin\Support\Provider\AuthInterface;
use Lagdo\DbAdmin\Support\Service\Export\AbstractFileSystem;
use Lagdo\DbAdmin\Support\Provider\Secret\AwsSecretConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\GcpSecretConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\InfisicalConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\KeyBuilderInterface;
use Lagdo\DbAdmin\Support\Provider\Secret\OpenBaoConfigProvider;

return [
    'admin' => [
        'ui' => [
            'toast' => [
                'lib' => 'butterup',
            ],
            'query' => [
                'editor' => 'cm', // 'cm' for CodeMirror or 'ace' for Ace Editor.
            ],
        ],
        'queries' => [
            'save' => [
                'editor' => true,
                'builder' => true,
                'library' => false,
            ],
            'enable' => [
                'preferences' => true,
                'history' => true,
                'favorite' => true,
            ],
            'history' => [
                'distinct' => false,
                'limit' => 10,
            ],
            'favorite' => [
                'limit' => 10,
            ],
        ],
    ],
    'audit' => [
        'queries' => [
            'database' => [
                // Same as the "servers" items, but "name" is the database name.
                // 'driver' => 'sqlite',
                // 'directory' => '/var/lib/sqlite/3',
                // 'name' => 'chinook.db',
                'driver' => 'pgsql',
                'host' => env('PGSQL17_DB_HOST'),
                'port' => env('PGSQL17_DB_PORT'),
                // 'username' => env('PGSQL17_DB_USERNAME'),
                // 'password' => env('PGSQL17_DB_PASSWORD'),
                'name' => 'auditdb',
            ],
            'pagination' => [
                'limit' => 10,
            ],
        ],
    ],
    // 'auth' => null, // No auth.
    'auth' => fn() => new class implements AuthInterface {
        public function userId(): string
        {
            return env('DBADMIN_USER', '');
        }
        public function name(): string
        {
            return env('DBADMIN_NAME', '');
        }
        public function roles(): array
        {
            return [];
        }
        public function audit(): string
        {
            return '/?page=audit';
        }
        public function logout(): string
        {
            return '/logout';
        }
    },
    // 'export' => null, // No export.
    'export' => fn() => new class extends AbstractFileSystem {
        protected function storage(): string
        {
            return 'exports';
        }
        protected function url(string $filename): string
        {
            return "/export.php?file=$filename";
        }
        protected function slug(string $userId): string
        {
            return ''; // Not used
        }
        protected function path(string $filename): string
        {
            return "users/$filename";
        }
    },
    // Comment all to use the default secret config provider.
    'secret' => [
        'reader' => InfisicalConfigProvider::class,
        'key' => fn() => new class implements KeyBuilderInterface {
            public function build(string $prefix, string $option = ''): string
            {
                // $username = Auth::userId(); // Use this to customize the key.
                return "users.{$prefix}.{$option}";
            }
        },
        // 'reader' => AwsSecretConfigProvider::class,
        // 'key' => fn() => new class implements KeyBuilderInterface {
        //     public function build(string $prefix, string $option = ''): string
        //     {
        //         // $username = Auth::userId(); // Use this to customize the key.
        //         // User names and passwords are stored in the same entries.
        //         return "users.{$prefix}";
        //     }
        // },
        // 'reader' => GcpSecretConfigProvider::class,
        // 'key' => fn() => new class implements KeyBuilderInterface {
        //     public function build(string $prefix, string $option = ''): string
        //     {
        //         // $username = Auth::userId(); // Use this to customize the key.
        //         return "db.users.{$prefix}.{$option}";
        //     }
        // },
        // 'reader' => OpenBaoConfigProvider::class,
        // 'key' => fn() => new class implements KeyBuilderInterface {
        //     public function build(string $prefix, string $option = ''): string
        //     {
        //         // $username = Auth::userId(); // Use this to customize the key.
        //         // The key is prefixed with "data/", for the KV2 API.
        //         return "data/db.users.{$prefix}.{$option}";
        //     }
        // },
    ],
];
