<?php

use Lagdo\DbAdmin\Support\Provider\AuthInterface;
use Lagdo\DbAdmin\Support\Provider\Secret\AwsSecretConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\GcpSecretConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\InfisicalConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\OpenBaoConfigProvider;

function getInfisicalSecretKey(AuthInterface $auth, string $prefix, string $option): string
{
    return "users.{$prefix}.{$option}";
}

function getAwsSecretSecretKey(AuthInterface $auth, string $prefix): string
{
    // User names and passwords are stored in the same entries.
    return "users.{$prefix}";
}

function getGcpSecretSecretKey(AuthInterface $auth, string $prefix, string $option): string
{
    return "db.users.{$prefix}.{$option}";
}

function getOpenBaoSecretKey(AuthInterface $auth, string $prefix, string $option): string
{
    // The key is prefixed with "data/", for the KV2 API.
    return "data/db.users.{$prefix}.{$option}";
}

// Uncomment the secret manager in use.
// Comment all if using no secret manager.

return [
    'reader' => InfisicalConfigProvider::class,
    'key' => getInfisicalSecretKey(...),
    // 'reader' => AwsSecretConfigProvider::class,
    // 'key' => getAwsSecretSecretKey(...),
    // 'reader' => GcpSecretConfigProvider::class,
    // 'key' => getGcpSecretSecretKey(...),
    // 'reader' => OpenBaoConfigProvider::class,
    // 'key' => getOpenBaoSecretKey(...),
];
