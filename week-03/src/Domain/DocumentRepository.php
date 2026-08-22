<?php

declare(strict_types=1);

namespace Week03\Domain;

interface DocumentRepository
{
    public function save(Document $document): Document;

    public function codeExists(string $code): bool;

    /**
     * @return array<int, Document>
     */
    public function findPublishedByRole(string $role): array;

    public function findById(int $id): ?Document;
}
