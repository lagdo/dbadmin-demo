<?php

use Lagdo\DbAdmin\Support\Facade\Auth;
use Lagdo\DbAdmin\Support\Provider;
use Lagdo\UiBuilder;

return [
    'template' => [
        // SB Admin template: https://startbootstrap.com/template/sb-admin
        'sb-admin' => [
            'builder' => UiBuilder\Bootstrap5\Builder::class,
        ],
        // CoreUI 5 template: https://coreui.io/product/free-bootstrap-admin-template/
        'coreui5' => [
            'builder' => UiBuilder\Bootstrap5\CoreUi\Builder::class,
        ],
        // Plain Admin template: https://plainadmin.com/
        'plain-admin' => [
            'builder' => UiBuilder\Bootstrap5\Builder::class,
        ],
        // Bulma Admin One template: https://github.com/vikdiesel/admin-one-bulma-dashboard
        'bulma' => [
            'builder' => UiBuilder\Bulma\Builder::class,
            'dialogs' => [
                'default' => [
                    'modal' => 'bulma',
                    'alert' => 'cute',
                    'confirm' => 'cute',
                ],
                'lib' => [
                    'use' => ['noty'],
                ],
            ],
        ],
    ],
    'secret' => [
        'infisical' => [
            'reader' => Provider\Secret\InfisicalConfigProvider::class,
            'key' => fn() => new class implements Provider\Secret\KeyBuilderInterface {
                public function build(string $prefix, string $option = ''): string
                {
                    // $username = Auth::userId(); // Use this to customize the key.
                    return "users.{$prefix}.{$option}";
                }
            },
        ],
        'aws-secret' => [
            'reader' => Provider\Secret\AwsSecretConfigProvider::class,
            'key' => fn() => new class implements Provider\Secret\KeyBuilderInterface {
                public function build(string $prefix, string $option = ''): string
                {
                    // $username = Auth::userId(); // Use this to customize the key.
                    // A single entry stores the user name and password in a json payload.
                    return "users.{$prefix}";
                }
            },
        ],
        'gcp-secret' => [
            'reader' => Provider\Secret\GcpSecretConfigProvider::class,
            'key' => fn() => new class implements Provider\Secret\KeyBuilderInterface {
                public function build(string $prefix, string $option = ''): string
                {
                    // $username = Auth::userId(); // Use this to customize the key.
                    return "db.users.{$prefix}.{$option}";
                }
            },
        ],
        'openbao' => [
            'reader' => Provider\Secret\OpenBaoConfigProvider::class,
            'key' => fn() => new class implements Provider\Secret\KeyBuilderInterface {
                public function build(string $prefix, string $option = ''): string
                {
                    // $username = Auth::userId(); // Use this to customize the key.
                    // The key is prefixed with "data/", for the KV2 API.
                    return "data/db.users.{$prefix}.{$option}";
                }
            },
        ],
        'azure-vault' => [
            'reader' => Provider\Secret\AzureVaultConfigProvider::class,
            'key' => fn() => new class implements Provider\Secret\KeyBuilderInterface {
                public function build(string $prefix, string $option = ''): string
                {
                    // $username = Auth::userId(); // Use this to customize the key.
                    return 'db-users-' . str_replace('.', '-', $prefix) . "-$option";
                }
            },
        ],
    ],
];
