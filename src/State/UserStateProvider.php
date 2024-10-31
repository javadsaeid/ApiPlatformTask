<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\State\ProviderInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class UserStateProvider implements ProviderInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Security $security,
    ) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $user = $this->security->getUser();
        $repository = $this->entityManager->getRepository(User::class);

        // If it's a collection
        if (empty($uriVariables)) {
            if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
                return $repository->findAll();
            }

            // For COMPANY_ADMIN and ROLE_USER, only return users from their company
            return $repository->findBy(['company' => $user->getCompany()]);
        }

        // If it's a single item
        $requestedUser = $repository->find($uriVariables['id']);
        if (!$requestedUser) {
            return null;
        }

        // SUPER_ADMIN can see all users
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            return $requestedUser;
        }

        // Others can only see users from their company
        if ($requestedUser->getCompany() === $user->getCompany()) {
            return $requestedUser;
        }

        return null;
    }
}

