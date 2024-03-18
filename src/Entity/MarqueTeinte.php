<?php

namespace App\Entity;

use App\Repository\MarqueTeinteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MarqueTeinteRepository::class)]
class MarqueTeinte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'marque', targetEntity: SearchTeinte::class)]
    private Collection $searchTeintes;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    public function __construct()
    {
        $this->searchTeintes = new ArrayCollection();
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

    /**
     * @return Collection<int, SearchTeinte>
     */
    public function getSearchTeintes(): Collection
    {
        return $this->searchTeintes;
    }

    public function addSearchTeinte(SearchTeinte $searchTeinte): static
    {
        if (!$this->searchTeintes->contains($searchTeinte)) {
            $this->searchTeintes->add($searchTeinte);
            $searchTeinte->setMarque($this);
        }

        return $this;
    }

    public function removeSearchTeinte(SearchTeinte $searchTeinte): static
    {
        if ($this->searchTeintes->removeElement($searchTeinte)) {
            // set the owning side to null (unless already changed)
            if ($searchTeinte->getMarque() === $this) {
                $searchTeinte->setMarque(null);
            }
        }

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }
}
