<?php

namespace App\Domains\Orders\DTOs;

readonly class OrderData
{
    public function __construct(
        public readonly ?int $memberId,
        public readonly string $name,
        public readonly string $email,
        public readonly string $paymentMethod,
        public readonly ?string $paymentReference,
        public readonly string $orderStatus,
        public readonly string $dateFinished,
        public readonly ?string $comments,
        public readonly string $currencyCode,
        public readonly ?string $currencyValue,
        public readonly string $taxTotal,
        public readonly string $total,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            memberId: $data['member_id'] ?? null,
            name: $data['name'],
            email: $data['email'],
            paymentMethod: $data['payment_method'],
            paymentReference: $data['payment_reference'] ?? null,
            orderStatus: $data['order_status'],
            dateFinished: $data['date_finished'],
            comments: $data['comments'] ?? null,
            currencyCode: $data['currency_code'],
            currencyValue: $data['currency_value'] ?? null,
            taxTotal: $data['tax_total'],
            total: $data['total'],
        );
    }

    public function toArray(): array
    {
        return [
            'member_id' => $this->memberId,
            'name' => $this->name,
            'email' => $this->email,
            'payment_method' => $this->paymentMethod,
            'payment_reference' => $this->paymentReference,
            'order_status' => $this->orderStatus,
            'date_finished' => $this->dateFinished,
            'comments' => $this->comments,
            'currency_code' => $this->currencyCode,
            'currency_value' => $this->currencyValue,
            'tax_total' => $this->taxTotal,
            'total' => $this->total,
        ];
    }
}