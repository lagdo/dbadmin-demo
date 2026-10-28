<?php

use Lagdo\DbAdmin\Support\Provider;
use Lagdo\DbAdmin\Support\Service;

return [
    'ui' => [
        'template' => 'sb-admin',
        // 'template' => 'coreui5',
        // 'template' => 'plain-admin',
        // 'template' => 'bulma',
        'assets' => [
            'url' => '/dbadmin',
        ],
        'query' => [
            // 'cm' for CodeMirror or 'ace' for Ace Editor.
            'editor' => 'cm',
        ],
    ],
    'admin' => [
        'queries' => [
            'save' => [
                'editor' => false,
                'builder' => false,
                'library' => false,
            ],
            'show' => [
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
    // 'secret' => 'infisical',
    // 'secret' => 'aws-secret',
    // 'secret' => 'gcp-secret',
    // 'secret' => 'openbao',
    // 'secret' => 'azure-vault',
];
