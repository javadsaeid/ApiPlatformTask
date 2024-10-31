<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class UserStateProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly Security $security
    ) {}

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        $user = $this->security->getUser();

        // Validate role assignment

        if ($this->security->isGranted('ROLE_COMPANY_ADMIN')) {
            //todo:
            // Company admin can only set ROLE_USER
            // Set the same company as the admin
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }
}