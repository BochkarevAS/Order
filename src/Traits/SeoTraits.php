<?php

declare(strict_types=1);

namespace App\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait SeoTraits
{
    #[ORM\Column(name: 'seo_title', type: Types::TEXT, nullable: true)]
    private string $title;

    #[ORM\Column(name: 'seo_keywords', type: Types::TEXT, nullable: true)]
    private string $keywords;

    #[ORM\Column(name: 'seo_description', type: Types::TEXT, nullable: true)]
    private string $description;

    #[ORM\Column(length: 256, unique: true)]
    private string $slug;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getKeywords(): string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): void
    {
        $this->keywords = $keywords;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }
}