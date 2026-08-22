<?php

declare(strict_types=1);

namespace Week03\Domain;

use DateTimeImmutable;

final class Document
{
    private const ALLOWED_STATUSES = ['draft', 'published', 'archived'];

    /**
     * @param array<int, string> $allowedRoles
     */
    private function __construct(
        private ?int $id,
        private string $code,
        private string $title,
        private string $description,
        private string $content,
        private string $status,
        private array $allowedRoles,
        private ?DateTimeImmutable $createdAt
    ) {
    }

    /**
     * @param array<int, string> $allowedRoles
     */
    public static function publish(
        string $code,
        string $title,
        string $description,
        string $content,
        array $allowedRoles,
        string $status = 'published'
    ): self {
        $normalizedCode = self::normalizeText($code, 'code');
        $normalizedTitle = self::normalizeText($title, 'title');
        $normalizedDescription = self::normalizeText($description, 'description');
        $normalizedContent = self::normalizeText($content, 'content');
        $normalizedStatus = self::normalizeText($status, 'status');
        $normalizedRoles = self::normalizeRoles($allowedRoles);

        if (!in_array($normalizedStatus, self::ALLOWED_STATUSES, true)) {
            throw new DocumentValidationException('status must be draft, published or archived');
        }

        return new self(
            null,
            $normalizedCode,
            $normalizedTitle,
            $normalizedDescription,
            $normalizedContent,
            $normalizedStatus,
            $normalizedRoles,
            new DateTimeImmutable('now')
        );
    }

    /**
     * @param array<int, string> $allowedRoles
     */
    public static function hydrate(
        int $id,
        string $code,
        string $title,
        string $description,
        string $content,
        string $status,
        array $allowedRoles,
        ?string $createdAt
    ): self {
        $normalizedStatus = self::normalizeText($status, 'status');
        if (!in_array($normalizedStatus, self::ALLOWED_STATUSES, true)) {
            throw new DocumentValidationException('status must be draft, published or archived');
        }

        return new self(
            $id,
            self::normalizeText($code, 'code'),
            self::normalizeText($title, 'title'),
            self::normalizeText($description, 'description'),
            self::normalizeText($content, 'content'),
            $normalizedStatus,
            self::normalizeRoles($allowedRoles),
            $createdAt === null ? null : new DateTimeImmutable($createdAt)
        );
    }

    public function withId(int $id): self
    {
        return new self(
            $id,
            $this->code,
            $this->title,
            $this->description,
            $this->content,
            $this->status,
            $this->allowedRoles,
            $this->createdAt
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'title' => $this->title,
            'description' => $this->description,
            'content' => $this->content,
            'status' => $this->status,
            'allowedRoles' => $this->allowedRoles,
            'createdAt' => $this->createdAt?->format(DATE_ATOM),
        ];
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function content(): string
    {
        return $this->content;
    }

    public function status(): string
    {
        return $this->status;
    }

    /**
     * @return array<int, string>
     */
    public function allowedRoles(): array
    {
        return $this->allowedRoles;
    }

    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isVisibleTo(string $role): bool
    {
        $normalizedRole = self::normalizeText($role, 'role');

        return in_array($normalizedRole, $this->allowedRoles, true);
    }

    private static function normalizeText(string $value, string $field): string
    {
        $normalized = trim($value);
        if ($normalized === '') {
            throw new DocumentValidationException($field . ' is required');
        }

        return $normalized;
    }

    /**
     * @param array<int, string> $roles
     * @return array<int, string>
     */
    private static function normalizeRoles(array $roles): array
    {
        $normalizedRoles = [];

        foreach ($roles as $role) {
            if (!is_string($role)) {
                throw new DocumentValidationException('allowedRoles must contain only strings');
            }

            $normalizedRole = self::normalizeText($role, 'allowed role');
            $normalizedRoles[$normalizedRole] = $normalizedRole;
        }

        $normalizedRoles = array_values($normalizedRoles);

        if ($normalizedRoles === []) {
            throw new DocumentValidationException('at least one allowed role is required');
        }

        return $normalizedRoles;
    }
}
