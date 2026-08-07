<?php

return [
    'ui' => [
        'assets' => [
            'url' => '/dbadmin',
        ],
    ],
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
    'audit' => [
        'enabled' => true,
        'allowed' => [
            // The emails of users that are allowed to access the audit page.
        ],
    ],
];
