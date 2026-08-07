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
    public function role(): string
    {
        return env('DBADMIN_ROLE', '');
    }
    public function logout(): string
    {
        return '/logout';
    }
};
