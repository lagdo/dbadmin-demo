<?php

return [
    'record' => [
        'library' => [
            'enabled' => false,
        ],
        'builder' => [
            'enabled' => true,
        ],
        'editor' => [
            'enabled' => true,
        ],
    ],
    'admin' => [
        'history' => [
            'show' => true,
            'distinct' => true,
            'limit' => 10,
        ],
        'favorite' => [
            'show' => true,
            'limit' => 10,
        ],
        'preferences' => [
            'enabled' => true,
        ],
    ],
    'database' => [
        // Same as the "servers" items, but "name" is the database name.
        'driver' => 'sqlite',
        'directory' => '/var/lib/sqlite/3',
        'name' => 'chinook.db',
    ],
];
