<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ContactRepository;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;


    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $facebook = null;

    #[ORM\Column(type: "string", length: 255, nullable: true)]
    private ?string $twitter = null;

    #[ORM\OneToOne(targetEntity: Member::class)]
    #[ORM\JoinColumn(name: "member_id", referencedColumnName: "id", nullable: true)]
    private ?Member $member = null;


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;
        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;
        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): self
    {
        $this->member = $member;
        return $this;
    }

    public function getContactDetail(): ?array
    {
        if ($this->facebook) {
            return ['type' => 'facebook', 'value' => $this->facebook];
        }
        if ($this->twitter) {
            return ['type' => 'twitter', 'value' => $this->twitter];
        }
        if ($this->email) {
            return ['type' => 'email', 'value' => $this->email];
        }

        return null;
    }

}
