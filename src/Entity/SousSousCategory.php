<?php

namespace App\Entity;

use App\Repository\SousSousCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousSousCategoryRepository::class)]
class SousSousCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'sousSousCategories')]
    private ?SousCategory $IdSousCategory = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIdSousCategory(): ?SousCategory
    {
        return $this->IdSousCategory;
    }

    public function setIdSousCategory(?SousCategory $IdSousCategory): self
    {
        $this->IdSousCategory = $IdSousCategory;

        return $this;
    }
}
