<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MemberRepository;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\Table(name: "members")]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: "NONE")]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $fullName;

    #[ORM\Column(type: "string", length: 255)]
    private string $country;

    #[ORM\Column(type: "string", length: 255)]
    private string $politicalGroup;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $nationalPoliticalGroup = null;

    // Getters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getPoliticalGroup(): string
    {
        return $this->politicalGroup;
    }

    public function getNationalPoliticalGroup(): ?string
    {
        return $this->nationalPoliticalGroup;
    }

    // Setters
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function setFullName(string $fullName): self
    {
        $this->fullName = $fullName;
        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;
        return $this;
    }

    public function setPoliticalGroup(string $politicalGroup): self
    {
        $this->politicalGroup = $politicalGroup;
        return $this;
    }

    public function setNationalPoliticalGroup(?string $nationalPoliticalGroup): self
    {
        $this->nationalPoliticalGroup = $nationalPoliticalGroup;
        return $this;
    }
}

