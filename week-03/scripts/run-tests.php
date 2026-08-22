<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';
require_once __DIR__ . '/../tests/TestSupport.php';

$testFiles = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/../tests', FilesystemIterator::SKIP_DOTS));
foreach ($iterator as $fileInfo) {
    if (!$fileInfo->isFile() || $fileInfo->getExtension() !== 'php' || $fileInfo->getFilename() === 'TestSupport.php') {
        continue;
    }

    $testFiles[] = $fileInfo->getPathname();
}

sort($testFiles);

$tests = [];
foreach ($testFiles as $testFile) {
    /** @var array<string, callable> $fileTests */
    $fileTests = require $testFile;
    $tests = array_merge($tests, $fileTests);
}

$passed = 0;
$failed = 0;

foreach ($tests as $name => $test) {
    try {
        $test();
        $passed++;
        echo "PASS: {$name}\n";
    } catch (Throwable $throwable) {
        $failed++;
        echo 'FAIL: ' . $name . ' - ' . $throwable->getMessage() . "\n";
    }
}

echo "Total: " . count($tests) . " | Passed: {$passed} | Failed: {$failed}\n";

exit($failed > 0 ? 1 : 0);
