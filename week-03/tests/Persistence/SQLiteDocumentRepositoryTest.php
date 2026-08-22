<?php

declare(strict_types=1);

use Week03\Domain\Document;

return [
    'repository persists and reads using a test database' => static function (): void {
        [, $repository] = test_create_repository(false);

        $document = Document::publish(
            'DOC-TEST-100',
            'Manual de soporte',
            'Guia para atencion tecnica',
            'Contenido ficticio de soporte documental.',
            ['Admin', 'TecnicoLab']
        );

        $saved = $repository->save($document);
        test_assert_true($saved->id() !== null, 'saved document should have id');
        test_assert_same(true, $repository->codeExists('DOC-TEST-100'));

        $loaded = $repository->findById((int) $saved->id());
        test_assert_true($loaded !== null, 'document should be readable after save');
        test_assert_same('Manual de soporte', $loaded->title());

        $visible = $repository->findPublishedByRole('Admin');
        test_assert_true(count($visible) >= 1, 'admin should see at least one document');
    },
];
