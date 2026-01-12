<?php
namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class AnneeScolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private string $nom;

    #[ORM\Column(type:'date')]
    private ?\DateTimeImmutable $dateDebut;

    #[ORM\Column(type:'date')]
    private ?\DateTimeImmutable $dateFin;

    #[ORM\OneToMany(mappedBy: 'anneeScolaire', targetEntity: CoursPeriode::class)]
    private Collection $coursPeriodes;

    public function __construct()
    {
        $this->coursPeriodes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function getDateDebut(): ?Date
    {
        return $this->dateDebut;
    }

    public function getDateFin(): ?Date
    {
        return $this->dateFin;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
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

    /** @return Collection<int, CoursPeriode */
    public function getCoursPeriodes(): Collection
    {
        return $this->coursPeriodes;
    }

    public function ajouterCoursPeriode(CoursPeriode $coursPeriode): self 
    {
        if (!$this->coursPeriodes->contains($coursPeriode)) {
            $this->coursPeriodes->add($coursPeriode);
            $coursPeriode->setAnneeScolaire($this);
        }

        return $this;
    }

    public function suprimerCoursPeriode(CoursPeriode $coursPeriode): self
    {
        if ($this->coursPeriodes->removeElement($coursPeriode)) {
            if ($coursPeriode->getAnneeScolaire() === $this) {
                $coursPeriode->setAnneeScolaire(null);
            }
        }

        return $this;
    }
}