<?php

namespace App\Entity;

use App\Repository\PotBDRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PotBDRepository::class)]
class PotBD
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?float $priceBd = null;

    #[ORM\Column(length: 255)]
    private ?string $potQ = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function __toString()
    {
        return $this->getPotQ();
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getPriceBd(): ?float
    {
        return $this->priceBd;
    }

    public function setPriceBd(float $priceBd): static
    {
        $this->priceBd = $priceBd;

        return $this;
    }

    public function getPotQ(): ?string
    {
        return $this->potQ;
    }

    public function setPotQ(string $potQ): static
    {
        $this->potQ = $potQ;

        return $this;
    }
}
