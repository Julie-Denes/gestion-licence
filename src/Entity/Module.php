<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length:50)]
    private string $code;

    #[ORM\Column]
    private string $nom;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column]
    private float $nbHeure;

    #[ORM\Column (type: 'boolean')]
    private bool $projetFilRouge;

    #[ORM\ManyToOne(inversedBy: 'module')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BlocEnseignement $blocEnseignement = null;

     public function getId(): ?int
    {
        return $this->id;
    }

     public function getCode(): ?int
    {
        return $this->code;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getNbHeure(): ?float
    {
        return $this->nbHeure;
    }

    public function getProjetFilRouge(): ?bool
    {
        return $this->projetFilRouge;
    }

    public function getBlocEnseignement(): ?BlocEnseignement
    {
        return $this->blocEnseignement;
    }

    public function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setNbHeure(float $nbHeure): self
    {
        $this->nbHeure = $nbHeure;
        return $this;
    }

    public function setProjetFilRouge(bool $projetFilRouge): self
    {
        $this->projetFilRouge = $projetFilRouge;
        return $this;
    }

    public function setBlocEnseignement(?BlocEnseignement $blocEnseignement): self
    {
        $this->blocEnseignement = $blocEnseignement;
        return $this;
    }

}