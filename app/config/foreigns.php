<?php

// The SQL SELECT clauses to get labels for foreign key columns.
return [
    'dbadmin-pgsql-14' => [
        'pagila' => [
            'public' => [
                'actor' => [
                    'actor_id' => [
                        'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                        'search' => fn(string $search) => "\"first_name\" ILIKE $search OR \"last_name\" ILIKE $search",
                    ],
                ],
                'store' => [
                    'store_id' => [
                        'select' => fn(int $textLength) => "SUBSTR(address.address, 1, $textLength)",
                        'search' => fn(string $search) => "address.address ILIKE $search",
                        'joins' => ["INNER JOIN address ON store.address_id=address.address_id"],
                    ],
                ],
                'customer' => [
                    'customer_id' => [
                        'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                        'search' => fn(string $search) => "\"first_name\" ILIKE $search OR \"last_name\" ILIKE $search",
                    ],
                ],
                'staff' => [
                    'staff_id' => [
                        'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                        'search' => fn(string $search) => "\"first_name\" ILIKE $search OR \"last_name\" ILIKE $search",
                    ],
                ],
            ],
        ],
        'sakila' => [
            'public' => [
                'actor' => [
                    'actor_id' => [
                        'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                        'search' => fn(string $search) => "\"first_name\" ILIKE $search OR \"last_name\" ILIKE $search",
                    ],
                ],
                'store' => [
                    'store_id' => [
                        'select' => fn(int $textLength) => "SUBSTR(address.address, 1, $textLength)",
                        'search' => fn(string $search) => "address.address ILIKE $search",
                        'joins' => ["INNER JOIN address ON store.address_id=address.address_id"],
                    ],
                ],
                'customer' => [
                    'customer_id' => [
                        'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                        'search' => fn(string $search) => "\"first_name\" ILIKE $search OR \"last_name\" ILIKE $search",
                    ],
                ],
                'staff' => [
                    'staff_id' => [
                        'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                        'search' => fn(string $search) => "\"first_name\" ILIKE $search OR \"last_name\" ILIKE $search",
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
                    'search' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
            'store' => [
                'store_id' => [
                    'select' => fn(int $textLength) => "SUBSTR(address.address, 1, $textLength)",
                    'search' => fn(string $search) => "LOWER(address.address) LIKE $search",
                    'joins' => ["INNER JOIN address ON store.address_id=address.address_id"],
                ],
            ],
            'customer' => [
                'customer_id' => [
                    'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                    'search' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
            'staff' => [
                'staff_id' => [
                    'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                    'search' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
        ],
        'employees' => [
            'employees' => [
                'emp_no' => [
                    'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                    'search' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
        ],
    ],
    'dbadmin-mysql' => [
        'sakila' => [
            'actor' => [
                'actor_id' => [
                    'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                    'search' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
            'store' => [
                'store_id' => [
                    'select' => fn(int $textLength) => "SUBSTR(address.address, 1, $textLength)",
                    'search' => fn(string $search) => "LOWER(address.address) LIKE $search",
                    'joins' => ["INNER JOIN address ON store.address_id=address.address_id"],
                ],
            ],
            'customer' => [
                'customer_id' => [
                    'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                    'search' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
            'staff' => [
                'staff_id' => [
                    'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                    'search' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
        ],
        'employees' => [
            'employees' => [
                'emp_no' => [
                    'select' => fn(int $textLength) => "SUBSTR(CONCAT(first_name, ' ', last_name), 1, $textLength)",
                    'search' => fn(string $search) => "LOWER(first_name) LIKE $search OR LOWER(last_name) LIKE $search",
                ],
            ],
        ],
    ],
    'tontine' => [
        'tontine' => [
            '*' => [
                'members' => [
                    'id' => [
                        'select' => fn(int $textLength) => "SUBSTR(defs.name, 1, $textLength)",
                        'search' => fn(string $search) => "defs.name ILIKE $search",
                        'joins' => ["INNER JOIN member_defs defs ON defs.id=members.def_id"],
                    ],
                ],
                'charges' => [
                    'id' => [
                        'select' => fn(int $textLength) => "SUBSTR(defs.name, 1, $textLength)",
                        'search' => fn(string $search) => "defs.name ILIKE $search",
                        'joins' => ["INNER JOIN charge_defs defs ON defs.id=charges.def_id"],
                    ],
                ],
                'pools' => [
                    'id' => [
                        'select' => fn(int $textLength) => "SUBSTR(defs.title, 1, $textLength)",
                        'search' => fn(string $search) => "defs.title ILIKE $search",
                        'joins' => ["INNER JOIN pool_defs defs ON defs.id=pools.def_id"],
                    ],
                ],
            ],
        ],
    ],
];
