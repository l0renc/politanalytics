<?php

// src/Service/MemberImporterService.php

namespace App\Service;

use App\Entity\Contact;
use App\Entity\Member;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DomCrawler\Crawler;
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

            $member = $this->entityManager->getRepository(Member::class)->findOneBy(['mepId' => $id]) ??  new Member();

            // Create or update Member entity
            $member->setMepId($id);
            $member->setFullName($fullName);
            $member->setCountry($country);
            $member->setPoliticalGroup($politicalGroup);
            $member->setNationalPoliticalGroup($nationalPoliticalGroup);
            $this->entityManager->persist($member);

            $mepDetailsResponse = $this->client->request('GET', $this->buildMemberProfileUrl($member));
            $crawler = new Crawler($mepDetailsResponse->getContent());

            // Scrape the Contacts section for contact details
            $this->importContacts($crawler, $member);
        }

        $this->entityManager->flush(); // Flush to save all the changes
    }

    private function buildMemberProfileUrl(Member $member): string
    {
        return 'https://www.europarl.europa.eu/meps/en/' . $member->getMepId() . '/' . strtoupper(str_replace(' ', '_', $member->getFullName())) . '/home';
    }

    private function importContacts(Crawler $crawler, Member $member): void
    {
        $contact = $this->entityManager->getRepository(Contact::class)->findOneBy(['member' => $member]) ?? new Contact();
        $contact->setMember($member);

        // Scraping email link
        $crawler->filter('.link_email')->each(function (Crawler $node) use ($member, $contact) {
            $href = $node->attr('href');
            $contact->setEmail($href);
        });

        // Scraping facebook link
        $crawler->filter('.link_fb')->each(function (Crawler $node) use ($member, $contact) {
            $href = $node->attr('href');
            $contact->setFacebook($href);
        });

        // Scraping tweeter link
        $crawler->filter('.link_tweet')->each(function (Crawler $node) use ($member, $contact) {
            $href = $node->attr('href');
            $contact->setTwitter($href);
        });

        $this->entityManager->persist($contact);
    }

}
