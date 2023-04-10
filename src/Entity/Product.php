<?php

declare(strict_types=1);

namespace App\Entity;

use App\Traits\SeoTraits;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product
{
    use SeoTraits;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    protected ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL)]
    private float $price = 0.0;

    #[ORM\Column(name: 'declaration', type: Types::TEXT, nullable: true)]
    private ?string $declaration = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $code = null;

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = floatval($price) ?? 0.0;
    }

    public function getDeclaration(): ?string
    {
        return $this->declaration;
    }

    public function setDeclaration(?string $declaration): void
    {
        $this->declaration = $declaration;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
}
