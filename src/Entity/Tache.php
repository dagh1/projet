<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TacheRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Tache
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=20000)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     *
     */
    private $dateInsert;

    /**
     * @ORM\Column(type="boolean")
     */
    private $check='False';

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Projet")
     * @ORM\JoinColumn(nullable=false)
     */
    private $projet;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDateInsert(): ?\DateTimeInterface
    {
        return $this->dateInsert;
    }

    public function setDateInsert(\DateTimeInterface $dateInsert): self
    {
        $this->dateInsert = new \DateTime("now");
        return $this;
    }
    public function getCheck()
    {
        return $this->check;
    }
    public function setCheck($check): void
    {
        $this->check = $check;
    }


    public function getProjet(): ?Projet
    {
        return $this->projet;
    }

    public function setProjet(?Projet $projet): self
    {
        $this->projet = $projet;

        return $this;
    }
}
