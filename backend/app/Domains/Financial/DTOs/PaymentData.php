<?php

namespace App\Domains\Financial\DTOs;

readonly class PaymentData
{
    public function __construct(
        public readonly int $memberId,
        public readonly ?int $invoiceId,
        public readonly string $paymentDate,
        public readonly string $amount,
        public readonly string $paymentMethod,
        public readonly ?string $reference,
        public readonly string $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            memberId: $data['member_id'],
            invoiceId: $data['invoice_id'] ?? null,
            paymentDate: $data['payment_date'],
            amount: $data['amount'],
            paymentMethod: $data['payment_method'],
            reference: $data['reference'] ?? null,
            status: $data['status'],
        );
    }

    public function toArray(): array
    {
        return [
            'member_id' => $this->memberId,
            'invoice_id' => $this->invoiceId,
            'payment_date' => $this->paymentDate,
            'amount' => $this->amount,
            'payment_method' => $this->paymentMethod,
            'reference' => $this->reference,
            'status' => $this->status,
        ];
    }
}