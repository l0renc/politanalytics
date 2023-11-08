<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MemberRepository;

#[ORM\Entity(repositoryClass: MemberRepository::class)]
#[ORM\Table(name: "members")]
class Member
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: "integer", unique: true)]
    private ?int $memberId = null;

    #[ORM\Column(type: "string", length: 255)]
    private string $fullName;

    #[ORM\Column(type: "string", length: 255)]
    private string $country;

    #[ORM\Column(type: "string", length: 255)]
    private string $politicalGroup;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $nationalPoliticalGroup = null;

    public function getMemberId(): string
    {
        return $this->memberId;

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
    public function setMemberId(int $id): self
    {
        $this->memberId = $id;
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

