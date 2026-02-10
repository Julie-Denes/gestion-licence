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

        #[ORM\ManyToOne(inversedBy: 'coursPeriodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnneeScolaire $anneeScolaire = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    
#[ORM\Column(type: 'date')]
private ?\DateTimeInterface $dateDebut = null;

#[ORM\Column(type: 'date')]
private ?\DateTimeInterface $dateFin = null;




public function getDateDebut(): ?\DateTimeInterface
{
    return $this->dateDebut;
}

public function getDateFin(): ?\DateTimeInterface
{
    return $this->dateFin;
}


public function setDateDebut(\DateTimeInterface $dateDebut): self
{
    $this->dateDebut = $dateDebut;
    return $this;
}

public function setDateFin(\DateTimeInterface $dateFin): self
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