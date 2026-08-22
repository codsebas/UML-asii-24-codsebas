<?php

declare(strict_types=1);

use Week03\Application\GetDocumentForRole;
use Week03\Application\PublishDocument;
use Week03\Domain\DocumentNotFoundException;
use Week03\Domain\UnauthorizedRoleException;

return [
    'publish document returns observable result' => static function (): void {
        [, $repository] = test_create_repository(false);

        $useCase = new PublishDocument($repository);
        $result = $useCase->execute([
            'code' => 'DOC-APP-001',
            'title' => 'Publicacion tecnica',
            'description' => 'Documento publicado desde application',
            'content' => 'Contenido ficticio para prueba.',
            'allowedRoles' => ['Admin', 'Medico'],
            'status' => 'published',
        ]);

        test_assert_same('DOC-APP-001', $result['code']);
        test_assert_same('published', $result['status']);
        test_assert_true($result['id'] !== null, 'published document should have id');
    },
    'authorized role can retrieve published document' => static function (): void {
        [, $repository] = test_create_repository(true);

        $useCase = new GetDocumentForRole($repository);
        $document = $useCase->execute(1, 'Medico');

        test_assert_same('DOC-OPENAPI-001', $document['code']);
        test_assert_same('published', $document['status']);
    },
    'unauthorized role is denied' => static function (): void {
        [, $repository] = test_create_repository(true);

        $useCase = new GetDocumentForRole($repository);

        test_assert_throws(
            UnauthorizedRoleException::class,
            static function () use ($useCase): void {
                $useCase->execute(1, 'Recepcionista');
            }
        );
    },
];
