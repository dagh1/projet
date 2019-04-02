<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EncadreurRepository")
 */
class Encadreur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8)
     */
    private $cin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Universite")
     * @ORM\JoinColumn(nullable=false)
     */
    private $universite;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Domaine")
     * @ORM\JoinColumn(nullable=false)
     */
    private $domaine;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Utilisateur", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Encadrement", mappedBy="encadreur", orphanRemoval=true)
     */
    private $encadrements;

    public function __construct()
    {
        $this->encadrements = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?string
    {
        return $this->cin;
    }

    public function setCin(string $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getUniversite(): ?Universite
    {
        return $this->universite;
    }

    public function setUniversite(?Universite $universite): self
    {
        $this->universite = $universite;

        return $this;
    }

    public function getDomaine(): ?Domaine
    {
        return $this->domaine;
    }

    public function setDomaine(?Domaine $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * @return Collection|Encadrement[]
     */
    public function getEncadrements(): Collection
    {
        return $this->encadrements;
    }

    public function addEncadrement(Encadrement $encadrement): self
    {
        if (!$this->encadrements->contains($encadrement)) {
            $this->encadrements[] = $encadrement;
            $encadrement->setEncadreur($this);
        }

        return $this;
    }

    public function removeEncadrement(Encadrement $encadrement): self
    {
        if ($this->encadrements->contains($encadrement)) {
            $this->encadrements->removeElement($encadrement);
            // set the owning side to null (unless already changed)
            if ($encadrement->getEncadreur() === $this) {
                $encadrement->setEncadreur(null);
            }
        }

        return $this;
    }


}
