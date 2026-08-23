<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $mailUser = null;

    #[ORM\Column(length: 250)]
    private ?string $mdpUser = null;

    #[ORM\Column]
    private array $roleUser = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMailUser(): ?string
    {
        return $this->mailUser;
    }

    public function setMailUser(string $mailUser): static
    {
        $this->mailUser = $mailUser;

        return $this;
    }

    public function getMdpUser(): ?string
    {
        return $this->mdpUser;
    }

    public function setMdpUser(string $mdpUser): static
    {
        $this->mdpUser = $mdpUser;

        return $this;
    }

    public function getRoleUser(): array
    {
        $roles = $this->roleUser;
        $roles[]='ROLE_USER';
        return array_unique($roles);
    }

    public function setRoleUser(array $roleUser): static
    {
        $this->roleUser = $roleUser;

        return $this;
    }
}
