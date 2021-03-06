<?php

namespace App\Entity;

use App\Entity\TypeBien;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DemandesRepository;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=DemandesRepository::class)
 */
class Demandes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="float")
     */
    private $superficie;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbre_pieces;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbre_appartements;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbre_studios;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $nbre_parking;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cave;

    /**
     * @ORM\Column(type="float")
     */
    private $budget;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $date_demande;

    /**
     * @gedmo\Slug(fields={"titre"})
     * @ORM\Column(type="string", length=120)
     */
    private $slug;


    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="demande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acheteur;

    /**
     * @ORM\ManyToMany(targetEntity=Adresse::class, inversedBy="demandes")
     */
    private $adresses;

    /**
     * @ORM\ManyToOne(targetEntity=TypeBien::class, inversedBy="demande")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_bien;




    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    public function __construct()
    {
        
        $this->adresses = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getSuperficie(): ?float
    {
        return $this->superficie;
    }

    public function setSuperficie(float $superficie): self
    {
        $this->superficie = $superficie;

        return $this;
    }

    public function getNbrePieces(): ?int
    {
        return $this->nbre_pieces;
    }

    public function setNbrePieces(?int $nbre_pieces): self
    {
        $this->nbre_pieces = $nbre_pieces;

        return $this;
    }

    public function getNbreAppartements(): ?int
    {
        return $this->nbre_appartements;
    }

    public function setNbreAppartements(?int $nbre_appartements): self
    {
        $this->nbre_appartements = $nbre_appartements;

        return $this;
    }

    public function getNbreStudios(): ?int
    {
        return $this->nbre_studios;
    }

    public function setNbreStudios(?int $nbre_studios): self
    {
        $this->nbre_studios = $nbre_studios;

        return $this;
    }

    public function getNbreParking(): ?int
    {
        return $this->nbre_parking;
    }

    public function setNbreParking(?int $nbre_parking): self
    {
        $this->nbre_parking = $nbre_parking;

        return $this;
    }

    public function getCave(): ?int
    {
        return $this->cave;
    }

    public function setCave(?int $cave): self
    {
        $this->cave = $cave;

        return $this;
    }

    public function getBudget(): ?float
    {
        return $this->budget;
    }

    public function setBudget(float $budget): self
    {
        $this->budget = $budget;

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

    public function getDateDemande(): ?\DateTimeInterface
    {
        return $this->date_demande;
    }

    // public function setDateDemande(\DateTimeInterface $date_demande): self
    // {
    //     $this->date_demande = $date_demande;

    //     return $this;
    // }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    // public function setSlug(string $slug): self
    // {
    //     $this->slug = $slug;

    //     return $this;
    // }


    public function getAcheteur(): ?User
    {
        return $this->acheteur;
    }

    public function setAcheteur(?User $acheteur): self
    {
        $this->acheteur = $acheteur;

        return $this;
    }

    /**
     * @return Collection|Adresse[]
     */
    public function getAdresses(): Collection
    {
        return $this->adresses;
    }

    public function addAdress(Adresse $adress): self
    {
        if (!$this->adresses->contains($adress)) {
            $this->adresses[] = $adress;
        }

        return $this;
    }

    public function removeAdress(Adresse $adress): self
    {
        $this->adresses->removeElement($adress);

        return $this;
    }

    public function getTypeBien(): ?TypeBien
    {
        return $this->type_bien;
    }

    public function setTypeBien(?TypeBien $type_bien): self
    {
        $this->type_bien = $type_bien;

        return $this;
    }

    public function getActif(): ?bool
    {
        return $this->actif;
    }

    public function setActif(bool $actif): self
    {
        $this->actif = $actif;

        return $this;
    }
}
