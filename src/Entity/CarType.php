<?php

namespace App\Entity;

use App\Repository\CarTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CarTypeRepository::class)]
class CarType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\OneToMany(mappedBy: 'car_type', targetEntity: PaintEstimations::class)]
    private Collection $paintEstimations;

    public function __construct()
    {
        $this->paintEstimations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): static
    {
        $this->illustration = $illustration;

        return $this;
    }

    /**
     * @return Collection<int, PaintEstimations>
     */
    public function getPaintEstimations(): Collection
    {
        return $this->paintEstimations;
    }

    public function addPaintEstimation(PaintEstimations $paintEstimation): static
    {
        if (!$this->paintEstimations->contains($paintEstimation)) {
            $this->paintEstimations->add($paintEstimation);
            $paintEstimation->setCarType($this);
        }

        return $this;
    }

    public function removePaintEstimation(PaintEstimations $paintEstimation): static
    {
        if ($this->paintEstimations->removeElement($paintEstimation)) {
            // set the owning side to null (unless already changed)
            if ($paintEstimation->getCarType() === $this) {
                $paintEstimation->setCarType(null);
            }
        }

        return $this;
    }
}
