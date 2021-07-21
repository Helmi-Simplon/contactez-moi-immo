<?php

namespace App\Entity;

use App\Repository\OffresRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffresRepository::class)
 */
class Offres
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
     * @ORM\ManyToOne(targetEntity=TypeBien::class, inversedBy="offre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type_bien;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="offre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $vendeur;

    /**
     * @ORM\ManyToOne(targetEntity=Adresse::class, inversedBy="offre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $adresse;

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
    private $places_parking;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cave;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_offre;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=120)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="offre")
     */
    private $image;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif;

    public function __construct()
    {
        $this->image = new ArrayCollection();
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

    public function getTypeBien(): ?TypeBien
    {
        return $this->type_bien;
    }

    public function setTypeBien(?TypeBien $type_bien): self
    {
        $this->type_bien = $type_bien;

        return $this;
    }

    public function getVendeur(): ?User
    {
        return $this->vendeur;
    }

    public function setVendeur(?User $vendeur): self
    {
        $this->vendeur = $vendeur;

        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;

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

    public function getPlacesParking(): ?int
    {
        return $this->places_parking;
    }

    public function setPlacesParking(?int $places_parking): self
    {
        $this->places_parking = $places_parking;

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getDateOffre(): ?\DateTimeInterface
    {
        return $this->date_offre;
    }

    public function setDateOffre(\DateTimeInterface $date_offre): self
    {
        $this->date_offre = $date_offre;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Images[]
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Images $image): self
    {
        if (!$this->image->contains($image)) {
            $this->image[] = $image;
            $image->setOffre($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getOffre() === $this) {
                $image->setOffre(null);
            }
        }

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
