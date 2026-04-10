<?php

namespace App\Domains\Content\DTOs;

readonly class ArticleData
{
    public function __construct(
        public readonly int $type,
        public readonly string $title,
        public readonly int $articleCategoryId,
        public readonly string $pageTitle,
        public readonly string $seoName,
        public readonly string $content,
        public readonly string $summary,
        public readonly string $seoDescription,
        public readonly bool $featured,
        public readonly bool $live,
        public readonly bool $categoryLive,
        public readonly int $popularity,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            title: $data['title'],
            articleCategoryId: $data['article_category_id'],
            pageTitle: $data['page_title'],
            seoName: $data['seo_name'],
            content: $data['content'],
            summary: $data['summary'],
            seoDescription: $data['seo_description'],
            featured: $data['featured'],
            live: $data['live'],
            categoryLive: $data['category_live'],
            popularity: $data['popularity'],
        );
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'title' => $this->title,
            'article_category_id' => $this->articleCategoryId,
            'page_title' => $this->pageTitle,
            'seo_name' => $this->seoName,
            'content' => $this->content,
            'summary' => $this->summary,
            'seo_description' => $this->seoDescription,
            'featured' => $this->featured,
            'live' => $this->live,
            'category_live' => $this->categoryLive,
            'popularity' => $this->popularity,
        ];
    }
}