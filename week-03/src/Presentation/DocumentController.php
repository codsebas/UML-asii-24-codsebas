<?php

declare(strict_types=1);

namespace Week03\Presentation;

use JsonException;
use Week03\Application\GetDocumentForRole;
use Week03\Application\ListDocumentsByRole;
use Week03\Application\PublishDocument;
use Week03\Domain\DocumentNotFoundException;
use Week03\Domain\DocumentStorageException;
use Week03\Domain\DocumentValidationException;
use Week03\Domain\DuplicateDocumentCodeException;
use Week03\Domain\UnauthorizedRoleException;

final class DocumentController
{
    public function __construct(
        private PublishDocument $publishDocument,
        private ListDocumentsByRole $listDocumentsByRole,
        private GetDocumentForRole $getDocumentForRole
    ) {
    }

    /**
     * @param array<string, string> $server
     * @param array<string, string> $query
     * @return array{status:int,body:array<string, mixed>}
     */
    public function handle(array $server, array $query, string $body): array
    {
        try {
            $method = strtoupper($server['REQUEST_METHOD'] ?? 'GET');
            $rawPath = $server['REQUEST_URI'] ?? $server['PATH_INFO'] ?? '/';
            $path = $this->normalizePath((string) parse_url($rawPath, PHP_URL_PATH));

            if ($method === 'GET' && $path === '/documents') {
                return $this->listByRole($query);
            }

            if ($method === 'GET' && preg_match('#^/documents/(\d+)$#', $path, $matches) === 1) {
                return $this->detailForRole((int) $matches[1], $query);
            }

            if ($method === 'POST' && $path === '/documents') {
                return $this->publish($body);
            }

            return $this->response(404, ['error' => 'route not found']);
        } catch (DuplicateDocumentCodeException $exception) {
            return $this->response(409, ['error' => $exception->getMessage()]);
        } catch (UnauthorizedRoleException $exception) {
            return $this->response(403, ['error' => $exception->getMessage()]);
        } catch (DocumentNotFoundException $exception) {
            return $this->response(404, ['error' => $exception->getMessage()]);
        } catch (DocumentValidationException $exception) {
            return $this->response(422, ['error' => $exception->getMessage()]);
        } catch (DocumentStorageException $exception) {
            return $this->response(503, ['error' => 'persistence error']);
        } catch (JsonException $exception) {
            return $this->response(400, ['error' => 'invalid JSON body']);
        } catch (\Throwable $exception) {
            return $this->response(500, ['error' => 'unexpected error']);
        }
    }

    /**
     * @param array<string, string> $query
     * @return array{status:int,body:array<string, mixed>}
     */
    private function listByRole(array $query): array
    {
        $role = (string) ($query['role'] ?? '');
        if (trim($role) === '') {
            return $this->response(422, ['error' => 'role is required']);
        }

        return $this->response(200, ['data' => $this->listDocumentsByRole->execute($role)]);
    }

    /**
     * @param array<string, string> $query
     * @return array{status:int,body:array<string, mixed>}
     */
    private function detailForRole(int $id, array $query): array
    {
        $role = (string) ($query['role'] ?? '');
        if (trim($role) === '') {
            return $this->response(422, ['error' => 'role is required']);
        }

        return $this->response(200, ['data' => $this->getDocumentForRole->execute($id, $role)]);
    }

    /**
     * @return array{status:int,body:array<string, mixed>}
     */
    private function publish(string $body): array
    {
        /** @var array<string, mixed> $input */
        $input = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        return $this->response(201, ['data' => $this->publishDocument->execute($input)]);
    }

    /**
     * @param array<string, mixed> $body
     * @return array{status:int,body:array<string, mixed>}
     */
    private function response(int $status, array $body): array
    {
        return ['status' => $status, 'body' => $body];
    }

    private function normalizePath(string $path): string
    {
        if ($path === '') {
            return '/';
        }

        $trimmed = '/' . trim($path, '/');

        return $trimmed === '/' ? '/' : $trimmed;
    }
}
