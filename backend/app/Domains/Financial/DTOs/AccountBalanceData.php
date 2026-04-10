<?php

namespace App\Domains\Financial\DTOs;

readonly class AccountBalanceData
{
    public function __construct(
        public readonly string $holderType,
        public readonly int $holderId,
        public readonly string $balance,
        public readonly string $currencyCode,
        public readonly ?string $lastTransactionAt,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            holderType: $data['holder_type'],
            holderId: $data['holder_id'],
            balance: $data['balance'],
            currencyCode: $data['currency_code'],
            lastTransactionAt: $data['last_transaction_at'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'holder_type' => $this->holderType,
            'holder_id' => $this->holderId,
            'balance' => $this->balance,
            'currency_code' => $this->currencyCode,
            'last_transaction_at' => $this->lastTransactionAt,
        ];
    }
}