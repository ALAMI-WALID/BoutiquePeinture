<?php

namespace App\Entity;

use App\Repository\SousCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SousCategoryRepository::class)]
class SousCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'sousCategories')]
    private ?Category $categoryID = null;

    #[ORM\OneToMany(mappedBy: 'IdSousCategory', targetEntity: SousSousCategory::class)]
    private Collection $sousSousCategories;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->sousSousCategories = new ArrayCollection();
    }

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

    public function getCategoryID(): ?Category
    {
        return $this->categoryID;
    }

    public function setCategoryID(?Category $categoryID): self
    {
        $this->categoryID = $categoryID;

        return $this;
    }

    /**
     * @return Collection<int, SousSousCategory>
     */
    public function getSousSousCategories(): Collection
    {
        return $this->sousSousCategories;
    }

    public function addSousSousCategory(SousSousCategory $sousSousCategory): self
    {
        if (!$this->sousSousCategories->contains($sousSousCategory)) {
            $this->sousSousCategories->add($sousSousCategory);
            $sousSousCategory->setIdSousCategory($this);
        }

        return $this;
    }

    public function removeSousSousCategory(SousSousCategory $sousSousCategory): self
    {
        if ($this->sousSousCategories->removeElement($sousSousCategory)) {
            // set the owning side to null (unless already changed)
            if ($sousSousCategory->getIdSousCategory() === $this) {
                $sousSousCategory->setIdSousCategory(null);
            }
        }

        return $this;
    }
}
