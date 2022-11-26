<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use http\Message;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Nomformation is required")]
    #[ORM\Column(length: 50)]
    private ?string $Nomformation = null;

    #[Assert\NotBlank(message: "Prixformation is required")]
    #[ORM\Column(length: 50)]
    private ?string $Prixformation = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Datedebut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Datefin = null;

    #[ORM\ManyToOne(inversedBy: 'Nomformation')]
    #[ORM\JoinColumn(name: 'FormateurID', referencedColumnName: 'id')]
    private ?Formateur $Formateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomformation(): ?string
    {
        return $this->Nomformation;
    }

    public function setNomformation(string $Nomformation): self
    {
        $this->Nomformation = $Nomformation;

        return $this;
    }

    public function getPrixformation(): ?string
    {
        return $this->Prixformation;
    }

    public function setPrixformation(string $Prixformation): self
    {
        $this->Prixformation = $Prixformation;

        return $this;
    }

    public function getDatedebut(): ?\DateTimeInterface
    {
        return $this->Datedebut;
    }

    public function setDatedebut(\DateTimeInterface $Datedebut): self
    {
        $this->Datedebut = $Datedebut;

        return $this;
    }

    public function getDatefin(): ?\DateTimeInterface
    {
        return $this->Datefin;
    }

    public function setDatefin(\DateTimeInterface $Datefin): self
    {
        $this->Datefin = $Datefin;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->Formateur;
    }

    public function setFormateur(?Formateur $Formateur): self
    {
        $this->Formateur = $Formateur;

        return $this;
    }
}
