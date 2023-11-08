<?php

namespace App\Transformer;

use App\Entity\Contact;
use App\Entity\Member;
use App\DTO\PersonDTO;
use App\DTO\ContactDTO;

class MemberTransformer
{
    public function transform(Member $member, $contact = null): PersonDTO
    {

        $fullName = explode(' ', $member->getFullName(), 2);
        $personDTO = new PersonDTO();
        $personDTO->id = $member->getId();
        $personDTO->firstName = $fullName[0];
        $personDTO->lastName = $fullName[1];
        $personDTO->country = $member->getCountry();
        $personDTO->politicalGroup = $member->getPoliticalGroup();

        if ($contact){
            $personDTO->contacts = $this->transformContact($contact);
        }

        return $personDTO;
    }

    private function transformContact(Contact $contact): ContactDTO
    {
        $contactDTO = new ContactDTO();
        $detail = $contact->getContactDetail();
        $contactDTO->type = $detail['type'] ?? null;
        $contactDTO->value = $detail['value'] ?? null;

        return $contactDTO;
    }
}
