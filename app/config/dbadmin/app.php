<?php

use Lagdo\DbAdmin\Support\Provider\AuthInterface;
use Lagdo\DbAdmin\Support\Service\Export\AbstractFileSystem;

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
                'distinct' => true,
                'limit' => 10,
            ],
            'favorite' => [
                'limit' => 10,
            ],
        ],
    ],
    'audit' => [
        'database' => [
            // Same as the "servers" items, but "name" is the database name.
            'driver' => 'sqlite',
            'directory' => '/var/lib/sqlite/3',
            'name' => 'chinook.db',
        ],
        'queries' => [
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
];
