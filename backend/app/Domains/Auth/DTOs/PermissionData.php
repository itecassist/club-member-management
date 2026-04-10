<?php

namespace App\Domains\Auth\DTOs;

readonly class PermissionData
{
    public function __construct(
        public readonly string $name,
        public readonly string $displayName,
        public readonly ?string $description,
        public readonly string $module,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            displayName: $data['display_name'],
            description: $data['description'] ?? null,
            module: $data['module'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'display_name' => $this->displayName,
            'description' => $this->description,
            'module' => $this->module,
        ];
    }
}