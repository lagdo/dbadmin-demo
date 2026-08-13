<?php

use Lagdo\DbAdmin\Support\Provider\Facade\Auth;
use Lagdo\DbAdmin\Support\Provider\Secret\AwsSecretConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\GcpSecretConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\InfisicalConfigProvider;
use Lagdo\DbAdmin\Support\Provider\Secret\OpenBaoConfigProvider;

$keyBuilderForInfisical = function(string $prefix, string $option): string {
    // $username = Auth::user(); // Use this to customize the key.
    return "users.{$prefix}.{$option}";
};

$keyBuilderForAwsSecret = function(string $prefix): string {
    // $username = Auth::user(); // Use this to customize the key.
    // User names and passwords are stored in the same entries.
    return "users.{$prefix}";
};

$keyBuilderForGcpSecret = function(string $prefix, string $option): string {
    // $username = Auth::user(); // Use this to customize the key.
    return "db.users.{$prefix}.{$option}";
};

$keyBuilderForOpenBao = function(string $prefix, string $option): string {
    // $username = Auth::user(); // Use this to customize the key.
    // The key is prefixed with "data/", for the KV2 API.
    return "data/db.users.{$prefix}.{$option}";
};

// Uncomment the secret manager in use.
// Comment all if using no secret manager.

return [
    'reader' => InfisicalConfigProvider::class,
    'key' => $keyBuilderForInfisical,
    // 'reader' => AwsSecretConfigProvider::class,
    // 'key' => $keyBuilderForAwsSecret,
    // 'reader' => GcpSecretConfigProvider::class,
    // 'key' => $keyBuilderForGcpSecret,
    // 'reader' => OpenBaoConfigProvider::class,
    // 'key' => $keyBuilderForOpenBao,
];
