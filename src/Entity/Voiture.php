<?php

namespace App\Entity;

use App\Repository\VoitureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VoitureRepository::class)
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\NotBlank
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $couleur;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $typeDeCarburant;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDeMiseEnCirculation;

    /**
     * @ORM\Column(type="boolean")
     */
    private $booleen;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbplace;

    /**
     * @ORM\OneToOne(targetEntity=Emplacment::class, mappedBy="idvoiture", cascade={"persist", "remove"})
     */
    private $emplacment;

    /**
     * @ORM\OneToMany(targetEntity=Contrat::class, mappedBy="voiture", orphanRemoval=true)
     */
    private $contrats;

    public function __construct()
    {
        $this->contrats = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getTypeDeCarburant(): ?string
    {
        return $this->typeDeCarburant;
    }

    public function setTypeDeCarburant(?string $typeDeCarburant): self
    {
        $this->typeDeCarburant = $typeDeCarburant;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateDeMiseEnCirculation(): ?\DateTimeInterface
    {
        return $this->dateDeMiseEnCirculation;
    }

    public function setDateDeMiseEnCirculation(\DateTimeInterface $dateDeMiseEnCirculation): self
    {
        $this->dateDeMiseEnCirculation = $dateDeMiseEnCirculation;

        return $this;
    }

    public function getBooleen(): ?bool
    {
        return $this->booleen;
    }

    public function setBooleen(bool $booleen): self
    {
        $this->booleen = $booleen;

        return $this;
    }

    public function getNbplace(): ?int
    {
        return $this->nbplace;
    }

    public function setNbplace(int $nbplace): self
    {
        $this->nbplace = $nbplace;

        return $this;
    }

    public function getEmplacment(): ?Emplacment
    {
        return $this->emplacment;
    }

    public function setEmplacment(Emplacment $emplacment): self
    {
        $this->emplacment = $emplacment;

        // set the owning side of the relation if necessary
        if ($emplacment->getIdvoiture() !== $this) {
            $emplacment->setIdvoiture($this);
        }

        return $this;
    }

    public function getIdcontrat(): ?Contrat
    {
        return $this->idcontrat;
    }

    public function setIdcontrat(?Contrat $idcontrat): self
    {
        $this->idcontrat = $idcontrat;

        return $this;
    }

    /**
     * @return Collection|Contrat[]
     */
    public function getContrats(): Collection
    {
        return $this->contrats;
    }

    public function addContrat(Contrat $contrat): self
    {
        if (!$this->contrats->contains($contrat)) {
            $this->contrats[] = $contrat;
            $contrat->setVoiture($this);
        }

        return $this;
    }

    public function removeContrat(Contrat $contrat): self
    {
        if ($this->contrats->removeElement($contrat)) {
            // set the owning side to null (unless already changed)
            if ($contrat->getVoiture() === $this) {
                $contrat->setVoiture(null);
            }
        }

        return $this;
    }
}
