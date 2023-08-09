<?php

namespace App\Entity;

use App\Repository\ShippingRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShippingRateRepository::class)]
class ShippingRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $startWeight = null;

    #[ORM\Column]
    private ?float $endWeight = null;

    #[ORM\Column]
    private ?float $rate = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartWeight(): ?float
    {
        return $this->startWeight;
    }

    public function setStartWeight(float $startWeight): static
    {
        $this->startWeight = $startWeight;

        return $this;
    }

    public function getEndWeight(): ?float
    {
        return $this->endWeight;
    }

    public function setEndWeight(float $endWeight): static
    {
        $this->endWeight = $endWeight;

        return $this;
    }

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(float $rate): static
    {
        $this->rate = $rate;

        return $this;
    }
}
