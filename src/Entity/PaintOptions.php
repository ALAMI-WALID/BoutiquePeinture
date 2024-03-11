<?php

namespace App\Entity;

use App\Repository\PaintOptionsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaintOptionsRepository::class)]
class PaintOptions
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'paint_option', targetEntity: PaintEstimations::class)]
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
            $paintEstimation->setPaintOption($this);
        }

        return $this;
    }

    public function removePaintEstimation(PaintEstimations $paintEstimation): static
    {
        if ($this->paintEstimations->removeElement($paintEstimation)) {
            // set the owning side to null (unless already changed)
            if ($paintEstimation->getPaintOption() === $this) {
                $paintEstimation->setPaintOption(null);
            }
        }

        return $this;
    }
}
