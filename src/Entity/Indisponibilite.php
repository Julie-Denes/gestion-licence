<?php

namespace App\Entity;

use App\Repository\IndisponibiliteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: IndisponibiliteRepository::class)]
class Indisponibilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le titre de l\'indisponibilité ne peut pas dépasser 255 caractères.')]
    private ?string $titre = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull(
        message: 'La date de début est obligatoire.'
    )]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull(
        message: 'La date de fin est obligatoire.'
    )]
  

    #[ORM\ManyToOne(inversedBy: 'indisponibilites')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotNull(
        message: 'Un enseignant est obligatoire.'
    )]
    private ?CorpsEnseignant $corpsEnseignant = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(?string $titre): self
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

    public function getCorpsEnseignant(): ?CorpsEnseignant
    {
        return $this->corpsEnseignant;
    }

    public function setCorpsEnseignant(?CorpsEnseignant $corpsEnseignant): self
    {
        $this->corpsEnseignant = $corpsEnseignant;

        return $this;
    }
}