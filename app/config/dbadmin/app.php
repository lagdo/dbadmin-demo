<?php

use Lagdo\DbAdmin\Support\Facade\Auth;
use Lagdo\DbAdmin\Support\Provider;
use Lagdo\DbAdmin\Support\Service;

return [
    'admin' => [
        'ui' => [
            'toast' => [
                'lib' => 'butterup',
            ],
            'query' => [
                // 'cm' for CodeMirror or 'ace' for Ace Editor.
                'editor' => 'cm',
            ],
        ],
        'queries' => [
            'save' => [
                'editor' => false,
                'builder' => false,
                'library' => false,
            ],
            'enable' => [
                'preferences' => false,
                'history' => false,
                'favorite' => false,
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
        'enabled' => false,
        'users' => [
            // The emails of users that are allowed to access the audit page.
        ],
        'queries' => [
            'database' => [
                // Same as the "servers" items, but "name" is the database name.
            ],
            'pagination' => [
                'limit' => 10,
            ],
        ],
    ],
    // 'auth' => null, // No auth.
    'auth' => fn() => new class implements Provider\AuthInterface {
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
    'export' => fn() => new class extends Service\Export\AbstractFileSystem {
        protected function storage(): string
        {
            return 'exports';
        }
        protected function url(string $filename): string
        {
            return "/export.php?file=$filename";
        }
        protected function path(string $filename): string
        {
            return "users/$filename";
        }
    },
    // Comment all to use the default secret config provider, which reads secret from the .env.dbadmin file.
    'secret' => [
        // 'reader' => Provider\Secret\InfisicalConfigProvider::class,
        // 'key' => fn() => new class implements Provider\Secret\KeyBuilderInterface {
        //     public function build(string $prefix, string $option = ''): string
        //     {
        //         // $username = Auth::userId(); // Use this to customize the key.
        //         return "users.{$prefix}.{$option}";
        //     }
        // },
        // 'reader' => Provider\Secret\AwsSecretConfigProvider::class,
        // 'key' => fn() => new class implements Provider\Secret\KeyBuilderInterface {
        //     public function build(string $prefix, string $option = ''): string
        //     {
        //         // $username = Auth::userId(); // Use this to customize the key.
        //         // User names and passwords are stored in the same entries.
        //         return "users.{$prefix}";
        //     }
        // },
        // 'reader' => Provider\Secret\GcpSecretConfigProvider::class,
        // 'key' => fn() => new class implements Provider\Secret\KeyBuilderInterface {
        //     public function build(string $prefix, string $option = ''): string
        //     {
        //         // $username = Auth::userId(); // Use this to customize the key.
        //         return "db.users.{$prefix}.{$option}";
        //     }
        // },
        // 'reader' => Provider\Secret\OpenBaoConfigProvider::class,
        // 'key' => fn() => new class implements Provider\Secret\KeyBuilderInterface {
        //     public function build(string $prefix, string $option = ''): string
        //     {
        //         // $username = Auth::userId(); // Use this to customize the key.
        //         // The key is prefixed with "data/", for the KV2 API.
        //         return "data/db.users.{$prefix}.{$option}";
        //     }
        // },
    ],
];
