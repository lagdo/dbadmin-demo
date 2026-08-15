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
