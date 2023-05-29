<?php

namespace App\Entity;

use App\Repository\BaseOfficielleDesCodesPostauxRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BaseOfficielleDesCodesPostauxRepository::class)]
class BaseOfficielleDesCodesPostaux
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Code_postale = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodePostale(): ?int
    {
        return $this->Code_postale;
    }

    public function setCodePostale(int $Code_postale): self
    {
        $this->Code_postale = $Code_postale;

        return $this;
    }
}
