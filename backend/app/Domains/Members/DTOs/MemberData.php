<?php

namespace App\Domains\Members\DTOs;

readonly class MemberData
{
    public function __construct(
        public readonly int $userId,
        public readonly ?string $title,
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $mobilePhone,
        public readonly ?string $dateOfBirth,
        public readonly string $gender,
        public readonly ?string $memberNumber,
        public readonly string $joinedAt,
        public readonly bool $isActive,
        public readonly array $roles,
        public readonly ?string $lastLoginAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            userId: $data['user_id'],
            title: $data['title'] ?? null,
            firstName: $data['first_name'],
            lastName: $data['last_name'],
            email: $data['email'],
            mobilePhone: $data['mobile_phone'],
            dateOfBirth: $data['date_of_birth'] ?? null,
            gender: $data['gender'],
            memberNumber: $data['member_number'] ?? null,
            joinedAt: $data['joined_at'],
            isActive: $data['is_active'] ?? true,
            roles: $data['roles'] ?? [],
            lastLoginAt: $data['last_login_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'user_id'       => $this->userId,
            'title'         => $this->title,
            'first_name'    => $this->firstName,
            'last_name'     => $this->lastName,
            'email'         => $this->email,
            'mobile_phone'  => $this->mobilePhone,
            'date_of_birth' => $this->dateOfBirth,
            'gender'        => $this->gender,
            'member_number' => $this->memberNumber,
            'joined_at'     => $this->joinedAt,
            'is_active'     => $this->isActive,
            'roles'         => $this->roles,
            'last_login_at' => $this->lastLoginAt,
        ];
    }
}
