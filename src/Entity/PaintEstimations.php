<?php

namespace App\Entity;

use App\Repository\PaintEstimationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaintEstimationsRepository::class)]
class PaintEstimations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'paintEstimations')]
    private ?CarType $car_type = null;

    #[ORM\ManyToOne(inversedBy: 'paintEstimations')]
    private ?PaintOptions $paint_option = null;

    #[ORM\Column]
    private ?int $PaintMin = null;

    #[ORM\Column]
    private ?int $PaintMax = null;

    #[ORM\Column]
    private ?int $BombeMin = null;

    #[ORM\Column]
    private ?int $BombeMax = null;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCarType(): ?CarType
    {
        return $this->car_type;
    }

    public function setCarType(?CarType $car_type): static
    {
        $this->car_type = $car_type;

        return $this;
    }

    public function getPaintOption(): ?PaintOptions
    {
        return $this->paint_option;
    }

    public function setPaintOption(?PaintOptions $paint_option): static
    {
        $this->paint_option = $paint_option;

        return $this;
    }

    public function getPaintMin(): ?int
    {
        return $this->PaintMin;
    }

    public function setPaintMin(int $PaintMin): static
    {
        $this->PaintMin = $PaintMin;

        return $this;
    }

    public function getPaintMax(): ?int
    {
        return $this->PaintMax;
    }

    public function setPaintMax(int $PaintMax): static
    {
        $this->PaintMax = $PaintMax;

        return $this;
    }

    public function getBombeMin(): ?int
    {
        return $this->BombeMin;
    }

    public function setBombeMin(int $BombeMin): static
    {
        $this->BombeMin = $BombeMin;

        return $this;
    }

    public function getBombeMax(): ?int
    {
        return $this->BombeMax;
    }

    public function setBombeMax(int $BombeMax): static
    {
        $this->BombeMax = $BombeMax;

        return $this;
    }


}
