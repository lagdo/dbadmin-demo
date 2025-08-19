<?php

use Lagdo\DbAdmin\Config\AuthInterface;
use Lagdo\DbAdmin\Config\UserFileReader;

return [
    'app' => [
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'container' => [
            'set' => [
                Psr\Log\LoggerInterface::class => function() {
                    $logFilePath = '/var/www/dbadmin-demo/logs/dbadmin';
                    return new Lagdo\DbAdmin\Demo\Log\Logger($logFilePath);
                },
                AuthInterface::class => function() {
                    return new class implements AuthInterface {
                        public function user(): string
                        {
                            return '';
                        }
                        public function role(): string
                        {
                            return ''; // No user roles.
                        }
                    };
                },
                UserFileReader::class => function($di) {
                    $auth = $di->get(AuthInterface::class);
                    $cfgFilePath = '/var/www/dbadmin-demo/dbadmin.php';
                    return new UserFileReader($auth, $cfgFilePath);
                }
            ],
        ],
        'packages' => [
            Lagdo\DbAdmin\Package::class => [
                'provider' => function(array $options) {
                    $reader = jaxon()->di()->get(UserFileReader::class);
                    return $reader->getOptions($options);
                },
                'access' => [
                    'server' => true,
                    'system' => false,
                ],
            ],
        ],
        'dialogs' => [
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'toastr',
                'confirm' => 'noty',
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'debug' => [
                'on' => false,
            ],
            'request' => [
                'uri' => 'ajax.php',
            ],
            'prefix' => [
                'class' => '',
            ],
        ],
        'js' => [
            'lib' => [
                // 'uri' => '',
            ],
            'app' => [
                'export' => false,
                'minify' => false,
                'uri' => '/jaxon',
                'dir' => __DIR__ . '/public/jaxon',
                // 'file' => '',
            ],
        ],
    ],
];
