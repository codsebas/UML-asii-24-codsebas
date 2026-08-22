<?php

declare(strict_types=1);

namespace Week03\Application;

use Week03\Domain\DocumentNotFoundException;
use Week03\Domain\DocumentRepository;
use Week03\Domain\UnauthorizedRoleException;

final class GetDocumentForRole
{
    public function __construct(private DocumentRepository $repository)
    {
    }

    /**
     * @return array<string, mixed>
     */
    public function execute(int $id, string $role): array
    {
        $document = $this->repository->findById($id);

        if ($document === null || !$document->isPublished()) {
            throw new DocumentNotFoundException('document not found');
        }

        if (!$document->isVisibleTo($role)) {
            throw new UnauthorizedRoleException('role is not authorized for this document');
        }

        return $document->toArray();
    }
}
