<?php
namespace App\Entity;

use App\Repository\AnneeScolaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity (repositoryClass: AnneeScolaireRepository::class)  ] 
class AnneeScolaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private string $nom;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: 'date')]
    private ?\DateTimeInterface $dateFin = null;

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

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
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