<?php

declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

use Week03\Application\GetDocumentForRole;
use Week03\Application\ListDocumentsByRole;
use Week03\Application\PublishDocument;
use Week03\Persistence\ConnectionFactory;
use Week03\Persistence\SQLiteDocumentRepository;
use Week03\Presentation\DocumentController;

$config = week03_default_config();
$pdo = ConnectionFactory::create($config);
$repository = new SQLiteDocumentRepository($pdo);

$controller = new DocumentController(
    new PublishDocument($repository),
    new ListDocumentsByRole($repository),
    new GetDocumentForRole($repository)
);

$result = $controller->handle($_SERVER, $_GET, file_get_contents('php://input') ?: '');

http_response_code($result['status']);
header('Content-Type: application/json; charset=utf-8');
echo json_encode($result['body'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
