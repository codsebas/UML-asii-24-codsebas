<?php

declare(strict_types=1);

use Week03\Application\PublishDocument;
use Week03\Application\GetDocumentForRole;
use Week03\Application\ListDocumentsByRole;
use Week03\Domain\Document;
use Week03\Domain\DocumentRepository;
use Week03\Domain\DocumentStorageException;
use Week03\Presentation\DocumentController;

return [
    'persistence error is handled through a double' => static function (): void {
        $repository = new class () implements DocumentRepository {
            public function save(Document $document): Document
            {
                throw new DocumentStorageException('simulated failure');
            }

            public function codeExists(string $code): bool
            {
                return false;
            }

            public function findPublishedByRole(string $role): array
            {
                return [];
            }

            public function findById(int $id): ?Document
            {
                return null;
            }
        };

        $controller = new DocumentController(
            new PublishDocument($repository),
            new ListDocumentsByRole($repository),
            new GetDocumentForRole($repository)
        );

        $result = $controller->handle(
            ['REQUEST_METHOD' => 'POST', 'PATH_INFO' => '/documents'],
            [],
            json_encode([
                'code' => 'DOC-FAIL-001',
                'title' => 'Error controlado',
                'description' => 'Prueba de persistencia',
                'content' => 'Contenido ficticio',
                'allowedRoles' => ['Admin'],
                'status' => 'published',
            ], JSON_THROW_ON_ERROR)
        );

        test_assert_same(503, $result['status']);
        test_assert_same('persistence error', $result['body']['error']);
    },
];
