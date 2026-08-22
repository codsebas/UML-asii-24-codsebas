<?php

declare(strict_types=1);

namespace Week03\Application;

use Week03\Domain\DocumentRepository;

final class ListDocumentsByRole
{
    public function __construct(private DocumentRepository $repository)
    {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function execute(string $role): array
    {
        $documents = $this->repository->findPublishedByRole($role);

        return array_map(static fn ($document) => $document->toArray(), $documents);
    }
}
