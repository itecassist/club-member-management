<?php

namespace App\Domains\Financial\DTOs;

readonly class InvoiceData
{
    public function __construct(
        public readonly int $memberId,
        public readonly string $invoiceNumber,
        public readonly string $issueDate,
        public readonly string $dueDate,
        public readonly string $status,
        public readonly string $subtotal,
        public readonly string $taxTotal,
        public readonly string $total,
        public readonly string $currencyCode,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            memberId: $data['member_id'],
            invoiceNumber: $data['invoice_number'],
            issueDate: $data['issue_date'],
            dueDate: $data['due_date'],
            status: $data['status'],
            subtotal: $data['subtotal'],
            taxTotal: $data['tax_total'],
            total: $data['total'],
            currencyCode: $data['currency_code'],
        );
    }

    public function toArray(): array
    {
        return [
            'member_id' => $this->memberId,
            'invoice_number' => $this->invoiceNumber,
            'issue_date' => $this->issueDate,
            'due_date' => $this->dueDate,
            'status' => $this->status,
            'subtotal' => $this->subtotal,
            'tax_total' => $this->taxTotal,
            'total' => $this->total,
            'currency_code' => $this->currencyCode,
        ];
    }
}