<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class BlocEnseignement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 20)]
    private string $code;

    #[ORM\Column]
    private string $nom;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column]
    private float $nbHeure;

    #[ORM\OneToMany(mappedBy: 'blocEnseignement', targetEntity: Module::class)]
    private Collection $module;

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

    /** @return Collection<int, Module */
    public function getModule(): Collection
    {
        return $this->module;
    }

    public function ajouterModule(Module $module): self 
    {
        if (!$this->module->contains($module)) {
            $this->module->add($module);
            $module->setBlocEnseignement($this);
        }

        return $this;
    }

    public function suprimerModule(Module $module): self
    {
        if ($this->module->removeElement($module)) {
            if ($module->getBlocEnseignement() === $this) {
                $module->setBlocEnseignement(null);
            }
        }

        return $this;
    }
}