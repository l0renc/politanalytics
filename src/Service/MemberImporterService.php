<?php

// src/Service/MemberImporterService.php

namespace App\Service;

use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class MemberImporterService
{
    private HttpClientInterface $client;
    private EntityManagerInterface $entityManager;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $entityManager)
    {
        $this->client = $client;
        $this->entityManager = $entityManager;
    }

    public function importMembers(): void
    {
        // The XML endpoint to fetch Memebers
        $response = $this->client->request('GET', 'https://www.europarl.europa.eu/meps/en/full-list/xml/a');
        $content = $response->getContent();

        // Using SimpleXMLElement to parse XML content
        $xml = new \SimpleXMLElement($content);
        foreach ($xml->mep as $mep) {
            $fullName = (string)$mep->fullName;
            $country = (string)$mep->country;
            $politicalGroup = (string)$mep->politicalGroup;
            $nationalPoliticalGroup = (string)$mep->nationalPoliticalGroup;
            $id = (int)$mep->id;

            $member = $this->entityManager->getRepository(Member::class)->findOneBy(['memberId' => $id]) ??  new Member();

            // Create or update Member entity
            $member->setMemberId($id);
            $member->setFullName($fullName);
            $member->setCountry($country);
            $member->setPoliticalGroup($politicalGroup);
            $member->setNationalPoliticalGroup($nationalPoliticalGroup);

            // Persist the Member entity
            $this->entityManager->persist($member);
        }

        $this->entityManager->flush(); // Flush to save all the changes
    }

}
