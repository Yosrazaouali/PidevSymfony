<?php

namespace App\Entity;

use App\Repository\FormateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FormateurRepository::class)]
class Formateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotBlank(message: "Nomformateur is required")]
    #[ORM\Column(length: 50)]
    private ?string $Nomformateur = null;


    #[Assert\NotBlank(message: "Prenomformateur is required")]
    #[ORM\Column(length: 50)]
    private ?string $Prenomformateur = null;


    #[Assert\NotBlank(message: "Bio is required")]
    #[ORM\Column(length: 50)]
    private ?string $Bio = null;


    #[Assert\NotBlank(message: "Telephone is required")]
    #[ORM\Column(length: 50)]
    private ?string $Telephone = null;

    #[Assert\NotBlank(message: "status is required")]
    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[Assert\NotBlank(message: "Diplome is required")]
    #[ORM\Column(length: 50)]
    private ?string $Diplome = null;



    #[Assert\NotBlank(message: "Email is required")]
    #[ORM\Column(length: 50)]
    private ?string $Email = null;

    #[ORM\OneToMany(mappedBy: 'Formateur', targetEntity: Formation::class)]
    private Collection $Nomformation;

    public function __construct()
    {
        $this->Nomformation = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomformateur(): ?string
    {
        return $this->Nomformateur;
    }

    public function setNomformateur(string $Nomformateur): self
    {
        $this->Nomformateur = $Nomformateur;

        return $this;
    }

    public function getPrenomformateur(): ?string
    {
        return $this->Prenomformateur;
    }

    public function setPrenomformateur(string $Prenomformateur): self
    {
        $this->Prenomformateur = $Prenomformateur;

        return $this;
    }

    public function getBio(): ?string
    {
        return $this->Bio;
    }

    public function setBio(string $Bio): self
    {
        $this->Bio = $Bio;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): self
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->Diplome;
    }

    public function setDiplome(string $Diplome): self
    {
        $this->Diplome = $Diplome;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * @return Collection<int, Formation>
     */
    public function getNomformation(): Collection
    {
        return $this->Nomformation;
    }

    public function addNomformation(Formation $nomformation): self
    {
        if (!$this->Nomformation->contains($nomformation)) {
            $this->Nomformation->add($nomformation);
            $nomformation->setFormateur($this);
        }

        return $this;
    }

    public function removeNomformation(Formation $nomformation): self
    {
        if ($this->Nomformation->removeElement($nomformation)) {
            // set the owning side to null (unless already changed)
            if ($nomformation->getFormateur() === $this) {
                $nomformation->setFormateur(null);
            }
        }

        return $this;
    }
}
