<?php

declare(strict_types=1);

return [
    'dsn' => 'sqlite:' . __DIR__ . '/../database/documentation.sqlite',
    'username' => null,
    'password' => null,
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ],
];
