<?php

use Lagdo\DbAdmin\Support\Provider\AuthInterface;

return [
    // 'default' => null, // No auth.
    'default' => fn() => new class implements AuthInterface {
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
];
