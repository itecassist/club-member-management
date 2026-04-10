<?php

namespace App\Domains\Content\DTOs;

readonly class FaqData
{
    public function __construct(
        public readonly string $question,
        public readonly string $answer,
        public readonly int $faqCategoryId,
        public readonly bool $live,
        public readonly int $popularity,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            question: $data['question'],
            answer: $data['answer'],
            faqCategoryId: $data['faq_category_id'],
            live: $data['live'],
            popularity: $data['popularity'],
        );
    }

    public function toArray(): array
    {
        return [
            'question' => $this->question,
            'answer' => $this->answer,
            'faq_category_id' => $this->faqCategoryId,
            'live' => $this->live,
            'popularity' => $this->popularity,
        ];
    }
}