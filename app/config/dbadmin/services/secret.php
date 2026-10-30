<?php

use Lagdo\DbAdmin\Support\Facade\Auth;
use Lagdo\DbAdmin\Support\Provider\Secret;

return [
    'infisical' => [
        'reader' => Secret\InfisicalConfigProvider::class,
        'key' => fn() => new class implements Secret\KeyBuilderInterface {
            public function build(string $prefix, string $option = ''): string
            {
                // $username = Auth::userId(); // Use this to customize the key.
                return "users.{$prefix}.{$option}";
            }
        },
    ],
    'aws-secret' => [
        'reader' => Secret\AwsSecretConfigProvider::class,
        'key' => fn() => new class implements Secret\KeyBuilderInterface {
            public function build(string $prefix, string $option = ''): string
            {
                // $username = Auth::userId(); // Use this to customize the key.
                // A single entry stores the user name and password in a json payload.
                return "users.{$prefix}";
            }
        },
    ],
    'gcp-secret' => [
        'reader' => Secret\GcpSecretConfigProvider::class,
        'key' => fn() => new class implements Secret\KeyBuilderInterface {
            public function build(string $prefix, string $option = ''): string
            {
                // $username = Auth::userId(); // Use this to customize the key.
                return "db.users.{$prefix}.{$option}";
            }
        },
    ],
    'openbao' => [
        'reader' => Secret\OpenBaoConfigProvider::class,
        'key' => fn() => new class implements Secret\KeyBuilderInterface {
            public function build(string $prefix, string $option = ''): string
            {
                // $username = Auth::userId(); // Use this to customize the key.
                // The key is prefixed with "data/", for the KV2 API.
                return "data/db.users.{$prefix}.{$option}";
            }
        },
    ],
    'azure-vault' => [
        'reader' => Secret\AzureVaultConfigProvider::class,
        'key' => fn() => new class implements Secret\KeyBuilderInterface {
            public function build(string $prefix, string $option = ''): string
            {
                // $username = Auth::userId(); // Use this to customize the key.
                return 'db-users-' . str_replace('.', '-', $prefix) . "-$option";
            }
        },
    ],
];
