<?php

namespace App\Entity;
use App\Repository\CodePeintureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodePeintureRepository::class)]
class CodePeinture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Code_peinture = null;

    #[ORM\Column(length: 255)]
    private ?string $Hersteller = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __toString(){
        return $this->getHersteller();
    }

    public function getCodePeinture(): ?string
    {
        return $this->Code_peinture;
    }

    public function setCodePeinture(string $Code_peinture): static
    {
        $this->Code_peinture = $Code_peinture;

        return $this;
    }

    public function getHersteller(): ?string
    {
        return $this->Hersteller;
    }

    public function setHersteller(string $Hersteller): static
    {
        $this->Hersteller = $Hersteller;

        return $this;
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
}
