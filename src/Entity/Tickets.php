<?php

namespace App\Entity;

use App\Repository\TicketsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TicketsRepository::class)]
class Tickets
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'adresse '{{ value }}' n'est pas un email valide.")]
    private ?string $mailClient = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $openDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $closeDate = null;

    #[ORM\Column(length: 250)]
    #[Assert\Length(min: 10, minMessage: "La description doit faire au moins 10 caractères.")]
    private ?string $descriptive = null;

    #[ORM\Column(length: 30, nullable: true)]
    private ?string $responsable = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Categories $category = null;

    #[ORM\ManyToOne(inversedBy: 'tickets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?States $state = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMailClient(): ?string
    {
        return $this->mailClient;
    }

    public function setMailClient(string $mailClient): static
    {
        $this->mailClient = $mailClient;

        return $this;
    }

    public function getOpenDate(): ?\DateTime
    {
        return $this->openDate;
    }

    public function setOpenDate(\DateTime $openDate): static
    {
        $this->openDate = $openDate;

        return $this;
    }

    public function getCloseDate(): ?\DateTime
    {
        return $this->closeDate;
    }

    public function setCloseDate(?\DateTime $closeDate): static
    {
        $this->closeDate = $closeDate;

        return $this;
    }

    public function getDescriptive(): ?string
    {
        return $this->descriptive;
    }

    public function setDescriptive(string $descriptive): static
    {
        $this->descriptive = $descriptive;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(?string $responsable): static
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getState(): ?States
    {
        return $this->state;
    }

    public function setState(?States $state): static
    {
        $this->state = $state;

        return $this;
    }
}
