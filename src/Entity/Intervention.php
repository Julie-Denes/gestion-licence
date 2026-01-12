<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Intervention
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private string $titre;

    #[ORM\Column(type:'datetime')]
    private \DateTimeInterface $dateDebut;

    #[ORM\Column(type:'datetime')]
    private \DateTimeInterface $dateFin;

    
    #[ORM\ManyToOne(inversedBy: 'interventions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Module $module = null;

    #[ORM\ManyToOne(inversedBy: 'interventions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeIntervention $typeIntervention = null;

    #[ORM\ManyToMany(targetEntity: CorpsEnseignant::class, inversedBy: 'interventions')]
    #[ORM\JoinTable(name: 'intervention_corps_enseignant')]
    private Collection $corpsEnseignants;

    public function __construct()
    {
        $this->corpsEnseignants = new ArrayCollection();
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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getModule(): ?Module
    {
        return $this->module;
    }

    public function setModule(?Module $module): self
    {
        $this->module = $module;
        return $this;
    }

    public function getTypeIntervention(): ?TypeIntervention
    {
        return $this->typeIntervention;
    }

    public function setTypeIntervention(?TypeIntervention $typeIntervention): self
    {
        $this->typeIntervention = $typeIntervention;
        return $this;
    }

    /**
     * @return Collection<int, CorpsEnseignant>
     */
    public function getCorpsEnseignants(): Collection
    {
        return $this->corpsEnseignants;
    }

    public function addCorpsEnseignant(CorpsEnseignant $corpsEnseignant): self
    {
        if (!$this->corpsEnseignants->contains($corpsEnseignant)) {
            $this->corpsEnseignants->add($corpsEnseignant);
        }

        return $this;
    }

    public function removeCorpsEnseignant(CorpsEnseignant $corpsEnseignant): self
    {
        $this->corpsEnseignants->removeElement($corpsEnseignant);
        return $this;
    }
    
}