<?php

namespace App\Domains\Shared\DTOs;

readonly class CountryData
{
    public function __construct(
        public readonly string $name,
        public readonly string $isoCode2,
        public readonly string $isoCode3,
        public readonly string $currencyCode,
        public readonly string $currencySymbol,
        public readonly bool $symbolLeft,
        public readonly string $decimalPlace,
        public readonly string $decimalPoint,
        public readonly string $thousandsPoint,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            isoCode2: $data['iso_code_2'],
            isoCode3: $data['iso_code_3'],
            currencyCode: $data['currency_code'],
            currencySymbol: $data['currency_symbol'],
            symbolLeft: $data['symbol_left'],
            decimalPlace: $data['decimal_place'],
            decimalPoint: $data['decimal_point'],
            thousandsPoint: $data['thousands_point'],
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'iso_code_2' => $this->isoCode2,
            'iso_code_3' => $this->isoCode3,
            'currency_code' => $this->currencyCode,
            'currency_symbol' => $this->currencySymbol,
            'symbol_left' => $this->symbolLeft,
            'decimal_place' => $this->decimalPlace,
            'decimal_point' => $this->decimalPoint,
            'thousands_point' => $this->thousandsPoint,
        ];
    }
}