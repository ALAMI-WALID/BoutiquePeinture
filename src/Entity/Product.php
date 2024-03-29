<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255)]
    private ?string $subtitle = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Category $category = null;

    #[ORM\Column(nullable: true)]
    private ?float $weight = null;

    #[ORM\Column(length: 255)]
    private ?string $articleCode = null;

    #[ORM\Column] 
    private ?bool $livrableHorsIleDeFrance = null;

    #[ORM\Column]
    private ?bool $isBest = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?SousSousCategory $SScategory = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?SousCategory $Scategory = null;

    #[ORM\Column(nullable: true)]
    private ?bool $promo = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Buses $buses = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Contenance $Size_Gobelet = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?PCFES $FiltrePeinture = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $FiltreContenance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PackVernisFiltre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Diluant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $grain = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimensionCale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $matierePapier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $qualitePapier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $epaisseurRuban = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DimensionPapierCacher = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $colorsAppret = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $raccordAir = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $DimensionTuyau = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeTuyau = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dimensionfiltreCabine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeFiltreCabine = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tailleEquipementProtection = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $technique = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $LienExterne = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Image::class)]
    private Collection $images;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column]
    private ?bool $hiddenProduit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $lienYoutube = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tailleGobelet = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }
    //title de admin(image)
    public function __toString()
    {
        return $this->getArticleCode().' - '.$this->getName();
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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getSubtitle(): ?string
    {
        return $this->subtitle;
    }

    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getArticleCode(): ?string
    {
        return $this->articleCode;
    }

    public function setArticleCode(string $articleCode): self
    {
        $this->articleCode = $articleCode;

        return $this;
    }

    public function getLivrableHorsIleDeFrance(): ?bool
    {
        return $this->livrableHorsIleDeFrance;
    }

    public function setLivrableHorsIleDeFrance(bool $livrableHorsIleDeFrance): self
    {
        $this->livrableHorsIleDeFrance = $livrableHorsIleDeFrance;

        return $this;
    }

    public function isIsBest(): ?bool
    {
        return $this->isBest;
    }

    public function setIsBest(bool $isBest): static
    {
        $this->isBest = $isBest;

        return $this;
    }

    public function getSScategory(): ?SousSousCategory
    {
        return $this->SScategory;
    }

    public function setSScategory(?SousSousCategory $SScategory): static
    {
        $this->SScategory = $SScategory;

        return $this;
    }

    public function getScategory(): ?SousCategory
    {
        return $this->Scategory;
    }

    public function setScategory(?SousCategory $Scategory): static
    {
        $this->Scategory = $Scategory;

        return $this;
    }

    public function isPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(?bool $promo): static
    {
        $this->promo = $promo;

        return $this;
    }

    public function getBuses(): ?Buses
    {
        return $this->buses;
    }

    public function setBuses(?Buses $buses): static
    {
        $this->buses = $buses;

        return $this;
    }

    public function getSizeGobelet(): ?Contenance
    {
        return $this->Size_Gobelet;
    }

    public function setSizeGobelet(?Contenance $Size_Gobelet): static
    {
        $this->Size_Gobelet = $Size_Gobelet;

        return $this;
    }

    public function getFiltrePeinture(): ?PCFES
    {
        return $this->FiltrePeinture;
    }

    public function setFiltrePeinture(?PCFES $FiltrePeinture): static
    {
        $this->FiltrePeinture = $FiltrePeinture;

        return $this;
    }

    public function getFiltreContenance(): ?string
    {
        return $this->FiltreContenance;
    }

    public function setFiltreContenance(?string $FiltreContenance): static
    {
        $this->FiltreContenance = $FiltreContenance;

        return $this;
    }

    public function getPackVernisFiltre(): ?string
    {
        return $this->PackVernisFiltre;
    }

    public function setPackVernisFiltre(?string $PackVernisFiltre): static
    {
        $this->PackVernisFiltre = $PackVernisFiltre;

        return $this;
    }

    public function getDiluant(): ?string
    {
        return $this->Diluant;
    }

    public function setDiluant(?string $Diluant): static
    {
        $this->Diluant = $Diluant;

        return $this;
    }

    public function getGrain(): ?string
    {
        return $this->grain;
    }

    public function setGrain(?string $grain): static
    {
        $this->grain = $grain;

        return $this;
    }

    public function getDimensionCale(): ?string
    {
        return $this->dimensionCale;
    }

    public function setDimensionCale(?string $dimensionCale): static
    {
        $this->dimensionCale = $dimensionCale;

        return $this;
    }

    public function getMatierePapier(): ?string
    {
        return $this->matierePapier;
    }

    public function setMatierePapier(?string $matierePapier): static
    {
        $this->matierePapier = $matierePapier;

        return $this;
    }

    public function getQualitePapier(): ?string
    {
        return $this->qualitePapier;
    }

    public function setQualitePapier(?string $qualitePapier): static
    {
        $this->qualitePapier = $qualitePapier;

        return $this;
    }

    public function getEpaisseurRuban(): ?string
    {
        return $this->epaisseurRuban;
    }

    public function setEpaisseurRuban(?string $epaisseurRuban): static
    {
        $this->epaisseurRuban = $epaisseurRuban;

        return $this;
    }

    public function getDimensionPapierCacher(): ?string
    {
        return $this->DimensionPapierCacher;
    }

    public function setDimensionPapierCacher(?string $DimensionPapierCacher): static
    {
        $this->DimensionPapierCacher = $DimensionPapierCacher;

        return $this;
    }

    public function getColorsAppret(): ?string
    {
        return $this->colorsAppret;
    }

    public function setColorsAppret(?string $colorsAppret): static
    {
        $this->colorsAppret = $colorsAppret;

        return $this;
    }

    public function getRaccordAir(): ?string
    {
        return $this->raccordAir;
    }

    public function setRaccordAir(?string $raccordAir): static
    {
        $this->raccordAir = $raccordAir;

        return $this;
    }

    public function getDimensionTuyau(): ?string
    {
        return $this->DimensionTuyau;
    }

    public function setDimensionTuyau(?string $DimensionTuyau): static
    {
        $this->DimensionTuyau = $DimensionTuyau;

        return $this;
    }

    public function getTypeTuyau(): ?string
    {
        return $this->typeTuyau;
    }

    public function setTypeTuyau(?string $typeTuyau): static
    {
        $this->typeTuyau = $typeTuyau;

        return $this;
    }

    public function getDimensionfiltreCabine(): ?string
    {
        return $this->dimensionfiltreCabine;
    }

    public function setDimensionfiltreCabine(?string $dimensionfiltreCabine): static
    {
        $this->dimensionfiltreCabine = $dimensionfiltreCabine;

        return $this;
    }

    public function getTypeFiltreCabine(): ?string
    {
        return $this->typeFiltreCabine;
    }

    public function setTypeFiltreCabine(?string $typeFiltreCabine): static
    {
        $this->typeFiltreCabine = $typeFiltreCabine;

        return $this;
    }

    public function getTailleEquipementProtection(): ?string
    {
        return $this->tailleEquipementProtection;
    }

    public function setTailleEquipementProtection(?string $tailleEquipementProtection): static
    {
        $this->tailleEquipementProtection = $tailleEquipementProtection;

        return $this;
    }

    public function getTechnique(): ?string
    {
        return $this->technique;
    }

    public function setTechnique(?string $technique): static
    {
        $this->technique = $technique;

        return $this;
    }

    public function getLienExterne(): ?string
    {
        return $this->LienExterne;
    }

    public function setLienExterne(?string $LienExterne): static
    {
        $this->LienExterne = $LienExterne;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function isHiddenProduit(): ?bool
    {
        return $this->hiddenProduit;
    }

    public function setHiddenProduit(bool $hiddenProduit): static
    {
        $this->hiddenProduit = $hiddenProduit;

        return $this;
    }

    public function getLienYoutube(): ?string
    {
        return $this->lienYoutube;
    }

    public function setLienYoutube(?string $lienYoutube): static
    {
        $this->lienYoutube = $lienYoutube;

        return $this;
    }

    public function getTailleGobelet(): ?string
    {
        return $this->tailleGobelet;
    }

    public function setTailleGobelet(?string $tailleGobelet): static
    {
        $this->tailleGobelet = $tailleGobelet;

        return $this;
    }

}
