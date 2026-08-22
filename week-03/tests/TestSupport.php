<?php

declare(strict_types=1);

use Week03\Persistence\ConnectionFactory;
use Week03\Persistence\SQLiteDocumentRepository;

function test_assert_true(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

/**
 * @template TExpected
 * @param TExpected $expected
 * @param mixed $actual
 */
function test_assert_same(mixed $expected, mixed $actual, string $message = ''): void
{
    if ($expected !== $actual) {
        $details = $message !== '' ? $message . ' ' : '';
        throw new RuntimeException($details . 'expected ' . var_export($expected, true) . ' got ' . var_export($actual, true));
    }
}

/**
 * @param class-string<Throwable> $exceptionClass
 */
function test_assert_throws(string $exceptionClass, callable $callback, string $message = ''): void
{
    try {
        $callback();
    } catch (Throwable $throwable) {
        if ($throwable instanceof $exceptionClass) {
            return;
        }

        throw new RuntimeException(($message !== '' ? $message . ' ' : '') . 'unexpected exception ' . get_class($throwable));
    }

    throw new RuntimeException(($message !== '' ? $message . ' ' : '') . 'expected exception ' . $exceptionClass . ' was not thrown');
}

/**
 * @return array{0:PDO,1:SQLiteDocumentRepository}
 */
function test_create_repository(bool $seed = false): array
{
    $databasePath = tempnam(sys_get_temp_dir(), 'week03_');
    if ($databasePath === false) {
        throw new RuntimeException('unable to create temporary database path');
    }

    if (file_exists($databasePath)) {
        unlink($databasePath);
    }

    $pdo = ConnectionFactory::create([
        'dsn' => 'sqlite:' . $databasePath,
        'options' => [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ],
    ]);

    $schemaSql = file_get_contents(__DIR__ . '/../database/schema.sql');
    if ($schemaSql === false) {
        throw new RuntimeException('unable to read schema.sql');
    }

    $pdo->exec($schemaSql);

    if ($seed) {
        $seedSql = file_get_contents(__DIR__ . '/../database/seed.sql');
        if ($seedSql === false) {
            throw new RuntimeException('unable to read seed.sql');
        }

        $pdo->exec($seedSql);
    }

    register_shutdown_function(static function () use ($databasePath): void {
        if (is_file($databasePath)) {
            @unlink($databasePath);
        }
    });

    return [$pdo, new SQLiteDocumentRepository($pdo)];
}
