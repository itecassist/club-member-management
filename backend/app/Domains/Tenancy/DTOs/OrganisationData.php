<?php

namespace App\Domains\Tenancy\DTOs;

readonly class OrganisationData
{
    public function __construct(
        public readonly string $name,
        public readonly string $seoName,
        public readonly string $email,
        public readonly ?string $phone,
        public readonly ?string $logo,
        public readonly ?string $website,
        public readonly ?string $description,
        public readonly bool $freeTrail,
        public readonly string $freeTrailEndDate,
        public readonly string $billingPolicy,
        public readonly bool $isActive,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            seoName: $data['seo_name'],
            email: $data['email'],
            phone: $data['phone'] ?? null,
            logo: $data['logo'] ?? null,
            website: $data['website'] ?? null,
            description: $data['description'] ?? null,
            freeTrail: $data['free_trail'],
            freeTrailEndDate: $data['free_trail_end_date'],
            billingPolicy: $data['billing_policy'],
            isActive: $data['is_active'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'seo_name' => $this->seoName,
            'email' => $this->email,
            'phone' => $this->phone,
            'logo' => $this->logo,
            'website' => $this->website,
            'description' => $this->description,
            'free_trail' => $this->freeTrail,
            'free_trail_end_date' => $this->freeTrailEndDate,
            'billing_policy' => $this->billingPolicy,
            'is_active' => $this->isActive,
        ];
    }
}