<?php

declare(strict_types=1);

spl_autoload_register(static function (string $class): void {
    $prefix = 'Week03\\';
    if (!str_starts_with($class, $prefix)) {
        return;
    }

    $relativeClass = substr($class, strlen($prefix));
    $file = __DIR__ . '/src/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (is_file($file)) {
        require_once $file;
    }
});

/**
 * @return array{dsn:string,username?:?string,password?:?string,options?:array<int,mixed>}
 */
function week03_default_config(): array
{
    $configFile = __DIR__ . '/config/database.php';
    if (!is_file($configFile)) {
        $configFile = __DIR__ . '/config/database.example.php';
    }

    /** @var array{dsn:string,username?:?string,password?:?string,options?:array<int,mixed>} $config */
    $config = require $configFile;

    return $config;
}
