<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

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

    #[ORM\ManyToMany(targetEntity: Module::class, inversedBy: 'corpsEnseignants')]
    #[ORM\JoinTable(name: 'enseignant_module')]
    private Collection $modules;


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

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function setNbHeure(float $nbHeure): self
    {
        $this->nbHeure = $nbHeure;
        return $this;
    }

    public function __construct()
    {
        $this->modules = new ArrayCollection();
    }

    /**
    * @return Collection<int, Module>
    */
    public function getModules(): Collection
    {
        return $this->modules;
    }

    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $this->modules->add($module);
        }

        return $this;
    }

    public function removeModule(Module $module): self
    {
        $this->modules->removeElement($module);
        return $this;
    }
}