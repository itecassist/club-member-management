<?php

namespace App\Domains\Subscriptions\DTOs;

readonly class SubscriptionData
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly ?int $virtualFormId,
        public readonly ?int $documentId,
        public readonly string $membership,
        public readonly string $membershipType,
        public readonly string $period,
        public readonly string $renewals,
        public readonly string $published,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            virtualFormId: $data['virtual_form_id'] ?? null,
            documentId: $data['document_id'] ?? null,
            membership: $data['membership'],
            membershipType: $data['membership_type'],
            period: $data['period'],
            renewals: $data['renewals'],
            published: $data['published'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'virtual_form_id' => $this->virtualFormId,
            'document_id' => $this->documentId,
            'membership' => $this->membership,
            'membership_type' => $this->membershipType,
            'period' => $this->period,
            'renewals' => $this->renewals,
            'published' => $this->published,
        ];
    }
}