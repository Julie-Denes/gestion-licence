<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Intervention;

#[ORM\Entity]
class Module
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length:50)]
    private string $code;

    #[ORM\Column]
    private string $nom;

    #[ORM\Column(type: Types::TEXT)]
    private string $description;

    #[ORM\Column]
    private float $nbHeure;

    #[ORM\Column (type: 'boolean')]
    private bool $projetFilRouge;

    #[ORM\OneToMany(mappedBy: 'module', targetEntity: Intervention::class, orphanRemoval: true)]
    private Collection $interventions;

    #[ORM\ManyToOne(inversedBy: 'module')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BlocEnseignement $blocEnseignement = null;

    #[ORM\ManyToMany(targetEntity: CorpsEnseignant::class, mappedBy: 'modules')]
    private Collection $corpsEnseignants;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'enfants')]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?self $parent = null;

    #[ORM\OneToMany(mappedBy: 'parent', targetEntity: self::class)]
    private Collection $enfants;



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

    public function getProjetFilRouge(): ?bool
    {
        return $this->projetFilRouge;
    }

    public function getBlocEnseignement(): ?BlocEnseignement
    {
        return $this->blocEnseignement;
    }

    public function getParent(): ?self
    {
        return $this->parent;
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

    public function setProjetFilRouge(bool $projetFilRouge): self
    {
        $this->projetFilRouge = $projetFilRouge;
        return $this;
    }

    public function setBlocEnseignement(?BlocEnseignement $blocEnseignement): self
    {
        $this->blocEnseignement = $blocEnseignement;
        return $this;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Collection<int, Module>
     */
    public function getEnfants(): Collection
    {
        return $this->enfants;
    }

    public function addEnfant(self $enfant): self
    {
        if (!$this->enfants->contains($enfant))
        {
            $this->enfants->add($enfants); //enfants ? avec un s ?
            $enfant->setParent($this);
        }
        return $this;
    }

    public function removeEnfant(self $enfant): self
    {
        if ($this->enfants->removeElement($enfant))
        {
            if ($enfant->getParent() === $this) 
            {
                $enfant->setParent(null);
            }
        }
        return $this;
    }

    public function __construct()
    {
        $this->corpsEnseignants = new ArrayCollection();
        $this->enfants = new ArrayCollection();
        $this->interventions = new ArrayCollection();
    }

    /**
    * @return Collection<int, CorpsEnseignant>
    */
    public function getCorpsEnseignants(): Collection
    {
        return $this->corpsEnseignants;
    }

    public function addCorpsEnseignant(CorpsEnseignant $enseignant): self
    {
        if (!$this->corpsEnseignants->contains($enseignant)) {
            $this->corpsEnseignants->add($enseignant);
            $enseignant->addModule($this);
        }

        return $this;
    }

    public function removeCorpsEnseignant(CorpsEnseignant $enseignant): self
    {
        if ($this->corpsEnseignants->removeElement($enseignant)) {
            $enseignant->removeModule($this);
        }

        return $this;
    }
    public function getInterventions(): Collection
{
    return $this->interventions;
}

public function addIntervention(Intervention $intervention): self
{
    if (!$this->interventions->contains($intervention)) {
        $this->interventions->add($intervention);
        $intervention->setModule($this);
    }

    return $this;
}

public function removeIntervention(Intervention $intervention): self
{
    if ($this->interventions->removeElement($intervention)) {
        if ($intervention->getModule() === $this) {
            $intervention->setModule(null);
        }
    }

    return $this;
}

}