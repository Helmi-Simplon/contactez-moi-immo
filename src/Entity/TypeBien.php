<?php

namespace App\Entity;

use App\Repository\TypeBienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=TypeBienRepository::class)
 */
class TypeBien
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $type;

    /**
     * @gedmo\Slug(fields={"type"})
     * @ORM\Column(type="string", length=120)
     */
    private $slug;


    /**
     * @ORM\OneToMany(targetEntity=Offres::class, mappedBy="type_bien")
     */
    private $offre;

    /**
     * @ORM\OneToMany(targetEntity=Demandes::class, mappedBy="type_bien", orphanRemoval=true)
     */
    private $demande;

    public function __construct()
    {
        $this->offre = new ArrayCollection();
        $this->demandes = new ArrayCollection();
        $this->demande = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    // public function setSlug(string $slug): self
    // {
    //     $this->slug = $slug;

    //     return $this;
    // }

    /**
     * @return Collection|Offres[]
     */
    public function getOffre(): Collection
    {
        return $this->offre;
    }

    public function addOffre(Offres $offre): self
    {
        if (!$this->offre->contains($offre)) {
            $this->offre[] = $offre;
            $offre->setTypeBien($this);
        }

        return $this;
    }

    public function removeOffre(Offres $offre): self
    {
        if ($this->offre->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getTypeBien() === $this) {
                $offre->setTypeBien(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Demandes[]
     */
    public function getDemande(): Collection
    {
        return $this->demande;
    }

    public function addDemande(Demandes $demande): self
    {
        if (!$this->demande->contains($demande)) {
            $this->demande[] = $demande;
            $demande->setTypeBien($this);
        }

        return $this;
    }

    public function removeDemande(Demandes $demande): self
    {
        if ($this->demande->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getTypeBien() === $this) {
                $demande->setTypeBien(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        
        return $this->type;
    }
    
}
