<?php

// src/Controller/MemberController.php

namespace App\Controller;

use App\Service\MemberService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityNotFoundException;

class MemberController extends AbstractController
{
    private MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    #[Route('/api/members', name: 'api_members_collection', methods: ['GET'])]
    public function collection(): JsonResponse
    {
        $members = $this->memberService->getMemberCollection();
        return $this->json($members);
    }

    #[Route('/api/members/{id}', name: 'api_members_item', methods: ['GET'])]
    public function item(int $id): JsonResponse
    {
        try {
            $member = $this->memberService->getMemberById($id);
            return $this->json($member);
        } catch (EntityNotFoundException $e) {
            return $this->json(['message' => $e->getMessage()], JsonResponse::HTTP_NOT_FOUND);
        }
    }
}
