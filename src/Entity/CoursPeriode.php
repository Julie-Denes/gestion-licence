<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class CoursPeriode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(type: 'date')]
    private Date $dateDebut;

    #[ORM\Column(type: 'date')]
    private Date $dateFin;

    #[ORM\ManyToOne(inversedBy: 'coursPeriodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeScolaire $anneeScolaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateDebut(): ?Date
    {
        return $this->dateDebut;
    }

    public function getDateFin(): ?Date
    {
        return $this->dateFin;
    }

    public function setDateDebut(Date $dateDebut): self
    {
        $this->dateDebut = $dateDebut;
        return $this;
    }

    public function setDateFin(Date $dateFin): self
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    public function getAnneeScolaire(): ?AnneeScolaire
    {
        return $this->anneeScolaire;
    }
    
    public function setAnneeScolaire(?AnneeScolaire $anneeScolaire): self
    {
        $this->anneeScolaire = $anneeScolaire;
        return $this;
    }
}