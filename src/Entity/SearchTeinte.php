<?php

namespace App\Entity;

use App\Repository\SearchTeinteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SearchTeinteRepository::class)]
class SearchTeinte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'searchTeinte')]
    private ?MarqueTeinte $marque = null;

    #[ORM\ManyToOne(inversedBy: 'searchTeinte')]
    private ?IllustrationTeinte $illustration = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMarque(): ?MarqueTeinte
    {
        return $this->marque;
    }

    public function setMarque(?MarqueTeinte $marque): static
    {
        $this->marque = $marque;

        return $this;
    }

    public function getIllustration(): ?IllustrationTeinte
    {
        return $this->illustration;
    }

    public function setIllustration(?IllustrationTeinte $illustration): static
    {
        $this->illustration = $illustration;

        return $this;
    }
}
