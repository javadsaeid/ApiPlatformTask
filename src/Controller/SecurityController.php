<?php

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(IriConverterInterface $iriConverter, #[CurrentUser] User $user = null): Response
    {
        if (!$user) {
            return $this->json([
                'error' => 'Invalid login credential.'
            ], 401);
        }

        return new Response(null, 204, [
            'Location' => $iriConverter->getIriFromResource($user)
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \RuntimeException('This should never be reached!');
    }
}