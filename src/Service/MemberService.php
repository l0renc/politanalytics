<?php

// src/Service/MemberService.php

namespace App\Service;

use App\Entity\Member;
use App\Repository\ContactRepository;
use App\Repository\MemberRepository;
use App\DTO\PersonDTO;
use App\Transformer\MemberTransformer;
use Doctrine\ORM\EntityNotFoundException;

class MemberService
{
    private MemberRepository $memberRepository;
    private ContactRepository $contactRepository;
    private MemberTransformer $transformer;

    public function __construct(MemberRepository $memberRepository, ContactRepository $contactRepository, MemberTransformer $transformer)
    {
        $this->memberRepository = $memberRepository;
        $this->contactRepository = $contactRepository;
        $this->transformer = $transformer;
    }

    public function getMemberCollection(): array
    {
        $members = $this->memberRepository->findAll();
        $membersDTOs = [];

        foreach ($members as $member) {
            $membersDTOs[] = $this->transformer->transform($member, false);
        }

        return $membersDTOs;
    }

    public function getMemberById(int $id): ?PersonDTO
    {
        $member = $this->memberRepository->find($id);
        $contact = $this->contactRepository->findOneBy(['member' => $member]);


        if (!$member) {
            throw new EntityNotFoundException('Member not found');
        }

        return $this->transformer->transform($member, $contact);
    }
}
