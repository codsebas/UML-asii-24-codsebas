<?php

declare(strict_types=1);

namespace Week03\Persistence;

use PDO;

final class ConnectionFactory
{
    /**
     * @param array{dsn:string,username?:?string,password?:?string,options?:array<int,mixed>} $config
     */
    public static function create(array $config): PDO
    {
        $pdo = new PDO(
            $config['dsn'],
            $config['username'] ?? null,
            $config['password'] ?? null,
            $config['options'] ?? []
        );

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return $pdo;
    }
}
