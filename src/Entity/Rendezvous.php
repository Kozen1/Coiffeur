<?php

namespace App\Entity;

use App\Repository\RendezvousRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RendezvousRepository::class)]
class Rendezvous
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $rendezvous = null;

    #[ORM\ManyToOne(inversedBy: 'rendezvous')]
    private ?Employe $employe = null;

    #[ORM\ManyToOne(inversedBy: 'rendezvous')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'rendezvous')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prestations $prestations = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRendezvous(): ?\DateTimeInterface
    {
        return $this->rendezvous;
    }

    public function setRendezvous(\DateTimeInterface $rendezvous): self
    {
        $this->rendezvous = $rendezvous;

        return $this;
    }

    public function getEmploye(): ?Employe
    {
        return $this->employe;
    }

    public function setEmploye(?Employe $employe): self
    {
        $this->employe = $employe;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPrestations(): ?Prestations
    {
        return $this->prestations;
    }

    public function setPrestations(?Prestations $prestations): self
    {
        $this->prestations = $prestations;

        return $this;
    }
}
