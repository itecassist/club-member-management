<?php

namespace App\Domains\Groups\DTOs;

readonly class GroupData
{
    public function __construct(
        public readonly string $name,
        public readonly string $type,
        public readonly ?string $description,
        public readonly ?int $primaryAdminId,
        public readonly ?int $maxMembers,
        public readonly bool $isActive,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            type: $data['type'],
            description: $data['description'] ?? null,
            primaryAdminId: $data['primary_admin_id'] ?? null,
            maxMembers: $data['max_members'] ?? null,
            isActive: $data['is_active'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'type' => $this->type,
            'description' => $this->description,
            'primary_admin_id' => $this->primaryAdminId,
            'max_members' => $this->maxMembers,
            'is_active' => $this->isActive,
        ];
    }
}