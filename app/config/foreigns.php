<?php

// The SQL SELECT clauses to get labels for foreign key columns.
return [
    'dbadmin-pgsql-14' => [
        'pagila' => [
            'public' => [
                'actor' => [
                    'actor_id' => [
                        'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                        'filter' => fn(string $search) => "\"first_name\" ILIKE $search OR \"last_name\" ILIKE $search",
                    ],
                ],
                'store' => [
                    'store_id' => [
                        'select' => fn(int $textLength) => "(SELECT SUBSTR(a.address, 1, $textLength) " .
                            "FROM address a WHERE store.address_id=a.address_id)",
                        'filter' => fn(string $search) => "EXISTS (SELECT address_id FROM address a " .
                            "WHERE store.address_id=a.address_id AND a.address ILIKE $search)",
                    ],
                ],
            ],
        ],
    ],
    'dbadmin-mariadb' => [
        'sakila' => [
            'actor' => [
                'actor_id' => [
                    'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                    'filter' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
            'store' => [
                'store_id' => [
                    'select' => fn(int $textLength) => "(SELECT SUBSTR(a.address, 1, $textLength) " .
                        "FROM address a WHERE store.address_id=a.address_id)",
                    'filter' => fn(string $search) => "EXISTS (SELECT address_id FROM address a " .
                        "WHERE store.address_id=a.address_id AND LOWER(a.address) LIKE $search)",
                ],
            ],
        ],
    ],
    'dbadmin-mysql' => [
        'sakila' => [
            'actor' => [
                'actor_id' => [
                    'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                    'filter' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
            'store' => [
                'store_id' => [
                    'select' => fn(int $textLength) => "(SELECT SUBSTR(a.address, 1, $textLength) " .
                        "FROM address a WHERE store.address_id=a.address_id)",
                    'filter' => fn(string $search) => "EXISTS (SELECT address_id FROM address a " .
                        "WHERE store.address_id=a.address_id AND LOWER(a.address) LIKE $search)",
                ],
            ],
        ],
    ],
];
