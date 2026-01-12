<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CorpsEnseignant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private string $nom;

    #[ORM\Column]
    private string $prenom;

    #[ORM\Column]
    private string $email;

    #[ORM\Column]
    private float $nbHeure;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getNbHeure(): ?float
    {
        return $this->nbHeure;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function setPrenom(string $prenom): ?self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function setEmail(string $semail): ?self
    {
        $this->email = $email;
        return $this;
    }

    public function setNbHeure(float $nbHeure): self
    {
        $this->nbHeure = $nbHeure;
        return $this;
    }
}