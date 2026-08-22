<?php

declare(strict_types=1);

namespace Week03\Persistence;

use PDO;
use PDOException;
use Week03\Domain\Document;
use Week03\Domain\DocumentRepository;
use Week03\Domain\DocumentStorageException;
use Week03\Domain\DuplicateDocumentCodeException;

final class SQLiteDocumentRepository implements DocumentRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function save(Document $document): Document
    {
        try {
            $this->pdo->beginTransaction();

            $statement = $this->pdo->prepare(
                'INSERT INTO documents (code, title, description, content, status, created_at)
                 VALUES (:code, :title, :description, :content, :status, :created_at)'
            );

            $statement->execute([
                ':code' => $document->code(),
                ':title' => $document->title(),
                ':description' => $document->description(),
                ':content' => $document->content(),
                ':status' => $document->status(),
                ':created_at' => $document->toArray()['createdAt'],
            ]);

            $documentId = (int) $this->pdo->lastInsertId();

            $roleStatement = $this->pdo->prepare(
                'INSERT INTO document_roles (document_id, role) VALUES (:document_id, :role)'
            );

            foreach ($document->allowedRoles() as $role) {
                $roleStatement->execute([
                    ':document_id' => $documentId,
                    ':role' => $role,
                ]);
            }

            $this->pdo->commit();

            return $document->withId($documentId);
        } catch (PDOException $exception) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            if (str_contains($exception->getMessage(), 'UNIQUE constraint failed: documents.code')) {
                throw new DuplicateDocumentCodeException('document code already exists', 0, $exception);
            }

            throw new DocumentStorageException('document persistence failed', 0, $exception);
        }
    }

    public function codeExists(string $code): bool
    {
        $statement = $this->pdo->prepare('SELECT 1 FROM documents WHERE code = :code LIMIT 1');
        $statement->execute([':code' => $code]);

        return $statement->fetchColumn() !== false;
    }

    public function findPublishedByRole(string $role): array
    {
        $statement = $this->pdo->prepare(
            'SELECT DISTINCT d.id, d.code, d.title, d.description, d.content, d.status, d.created_at
             FROM documents d
             INNER JOIN document_roles dr ON dr.document_id = d.id
             WHERE d.status = :status AND dr.role = :role
             ORDER BY d.created_at DESC, d.id DESC'
        );
        $statement->execute([
            ':status' => 'published',
            ':role' => $role,
        ]);

        $documents = [];
        while ($row = $statement->fetch()) {
            $documents[] = $this->hydrateDocument((array) $row);
        }

        return $documents;
    }

    public function findById(int $id): ?Document
    {
        $statement = $this->pdo->prepare(
            'SELECT id, code, title, description, content, status, created_at
             FROM documents
             WHERE id = :id
             LIMIT 1'
        );
        $statement->execute([':id' => $id]);

        $row = $statement->fetch();
        if ($row === false) {
            return null;
        }

        return $this->hydrateDocument((array) $row);
    }

    /**
     * @param array<string, mixed> $row
     */
    private function hydrateDocument(array $row): Document
    {
        $rolesStatement = $this->pdo->prepare(
            'SELECT role FROM document_roles WHERE document_id = :document_id ORDER BY role ASC'
        );
        $rolesStatement->execute([':document_id' => (int) $row['id']]);

        $roles = [];
        while ($roleRow = $rolesStatement->fetch()) {
            $roles[] = (string) $roleRow['role'];
        }

        return Document::hydrate(
            (int) $row['id'],
            (string) $row['code'],
            (string) $row['title'],
            (string) $row['description'],
            (string) $row['content'],
            (string) $row['status'],
            $roles,
            $row['created_at'] !== null ? (string) $row['created_at'] : null
        );
    }
}
