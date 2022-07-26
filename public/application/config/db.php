<?php

return [
    'pgsql' => [
        'host' => getenv('DB_HOST') ?? 'host',
        'dbname' => getenv('DB_DATABASE') ?? 'db',
        'user' => getenv('DB_USERNAME') ?? 'usr',
        'password' => getenv('DB_PASSWORD') ?? 'qwerty'
    ],
    'mysql' => [
        'host' => 'postgres',
        'dbname' => 'postgres',
        'user' => 'postgres',
        'password' => 'postgres'
    ],
];