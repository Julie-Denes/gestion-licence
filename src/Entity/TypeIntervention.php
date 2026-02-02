<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Intervention;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
class TypeIntervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private string $nom;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column(length: 20)]
    private string $couleur;

    #[ORM\OneToMany(mappedBy: 'typeIntervention', targetEntity: Intervention::class, orphanRemoval: true)]
private Collection $interventions;

public function __construct()
{
    $this->interventions = new ArrayCollection();
}

public function getInterventions(): Collection
{
    return $this->interventions;
}

public function addIntervention(Intervention $intervention): self
{
    if (!$this->interventions->contains($intervention)) {
        $this->interventions->add($intervention);
        $intervention->setTypeIntervention($this);
    }

    return $this;
}

public function removeIntervention(Intervention $intervention): self
{
    if ($this->interventions->removeElement($intervention)) {
        if ($intervention->getTypeIntervention() === $this) {
            $intervention->setTypeIntervention(null);
        }
    }

    return $this;
}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
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

    public function setCouleur(string $couleur): self 
    {
        $this->couleur = $couleur;
        return $this;
    }
}