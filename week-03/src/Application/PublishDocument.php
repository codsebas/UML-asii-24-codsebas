<?php

declare(strict_types=1);

namespace Week03\Application;

use Week03\Domain\Document;
use Week03\Domain\DocumentRepository;
use Week03\Domain\DuplicateDocumentCodeException;

final class PublishDocument
{
    public function __construct(private DocumentRepository $repository)
    {
    }

    /**
     * @param array<string, mixed> $input
     * @return array<string, mixed>
     */
    public function execute(array $input): array
    {
        $document = Document::publish(
            (string) ($input['code'] ?? ''),
            (string) ($input['title'] ?? ''),
            (string) ($input['description'] ?? ''),
            (string) ($input['content'] ?? ''),
            is_array($input['allowedRoles'] ?? null) ? $input['allowedRoles'] : [],
            (string) ($input['status'] ?? 'published')
        );

        if ($this->repository->codeExists($document->code())) {
            throw new DuplicateDocumentCodeException('document code already exists');
        }

        return $this->repository->save($document)->toArray();
    }
}
