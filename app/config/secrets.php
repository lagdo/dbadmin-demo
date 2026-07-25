<?php

use Lagdo\DbAdmin\Support\Provider\AuthInterface;
use Lagdo\DbAdmin\Support\Provider\Secret\AwsSecretConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\GcpSecretConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\InfisicalConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\OpenBaoConfigProvider;

function getInfisicalSecretKey(string $prefix, string $option, AuthInterface $auth): string
{
    return "users.{$prefix}.{$option}";
}

function getAwsSecretSecretKey(string $prefix, AuthInterface $auth): string
{
    // User names and passwords are stored in the same entries.
    return "users.{$prefix}";
}

function getGcpSecretSecretKey(string $prefix, string $option, AuthInterface $auth): string
{
    return "db.users.{$prefix}.{$option}";
}

function getOpenBaoSecretKey(string $prefix, string $option, AuthInterface $auth): string
{
    // The key is prefixed with "data/", for the KV2 API.
    return "data/db.users.{$prefix}.{$option}";
}

return [
    'auth' => fn() => new class implements AuthInterface {
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
    // 'reader' => InfisicalConfigProvider::class,
    'container' => [
        'extend' => [
            InfisicalConfigProvider::class => fn(InfisicalConfigProvider $provider) =>
                $provider->setSecretKeyBuilder(getInfisicalSecretKey(...)),
            AwsSecretConfigProvider::class => fn(AwsSecretConfigProvider $provider) =>
                $provider->setSecretKeyBuilder(getAwsSecretSecretKey(...)),
            GcpSecretConfigProvider::class => fn(GcpSecretConfigProvider $provider) =>
                $provider->setSecretKeyBuilder(getGcpSecretSecretKey(...)),
            OpenBaoConfigProvider::class => fn(OpenBaoConfigProvider $provider) =>
                $provider->setSecretKeyBuilder(getOpenBaoSecretKey(...)),
        ],
    ],
];
