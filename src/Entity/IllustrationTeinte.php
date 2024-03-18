<?php

namespace App\Entity;

use App\Repository\IllustrationTeinteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IllustrationTeinteRepository::class)]
class IllustrationTeinte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\OneToMany(mappedBy: 'illustration', targetEntity: SearchTeinte::class)]
    private Collection $searchTeintes;

    public function __construct()
    {
        $this->searchTeintes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $searchTeinte->setIllustration($this);
        }

        return $this;
    }

    public function removeSearchTeinte(SearchTeinte $searchTeinte): static
    {
        if ($this->searchTeintes->removeElement($searchTeinte)) {
            // set the owning side to null (unless already changed)
            if ($searchTeinte->getIllustration() === $this) {
                $searchTeinte->setIllustration(null);
            }
        }

        return $this;
    }
}
