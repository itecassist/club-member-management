<?php

namespace App\Domains\Products\DTOs;

readonly class ProductData
{
    public function __construct(
        public readonly int $lookupId,
        public readonly string $name,
        public readonly string $code,
        public readonly ?string $description,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            lookupId: $data['lookup_id'],
            name: $data['name'],
            code: $data['code'],
            description: $data['description'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'lookup_id' => $this->lookupId,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
        ];
    }
}