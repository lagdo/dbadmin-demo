<?php

use Lagdo\DbAdmin\Support\Provider\AuthInterface;

// return null; // No auth.

return fn() => new class implements AuthInterface {
    public function user(): string
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
};
