<?php

declare(strict_types=1);

use Week03\Domain\Document;
use Week03\Domain\DocumentValidationException;

return [
    'document without allowed roles is rejected' => static function (): void {
        test_assert_throws(
            DocumentValidationException::class,
            static function (): void {
                Document::publish('DOC-EMPTY-001', 'Titulo', 'Resumen', 'Contenido', []);
            }
        );
    },
];
