<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use Week03\Persistence\ConnectionFactory;

$config = week03_default_config();
$pdo = ConnectionFactory::create($config);

$schemaSql = file_get_contents(__DIR__ . '/../database/schema.sql');
$seedSql = file_get_contents(__DIR__ . '/../database/seed.sql');

if ($schemaSql === false || $seedSql === false) {
    fwrite(STDERR, "Unable to read database SQL files\n");
    exit(1);
}

$pdo->exec($schemaSql);
$pdo->exec($seedSql);

echo "Database initialized\n";
