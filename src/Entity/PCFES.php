<?php

namespace App\Entity;

use App\Repository\PCFESRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PCFESRepository::class)]
class PCFES
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $TypePeinture = null;

    #[ORM\OneToMany(mappedBy: 'FiltrePeinture', targetEntity: Product::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    public function __toString()
    {
        return  $this->getTypePeinture();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypePeinture(): ?string
    {
        return $this->TypePeinture;
    }

    public function setTypePeinture(string $TypePeinture): static
    {
        $this->TypePeinture = $TypePeinture;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setFiltrePeinture($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getFiltrePeinture() === $this) {
                $product->setFiltrePeinture(null);
            }
        }

        return $this;
    }
}
