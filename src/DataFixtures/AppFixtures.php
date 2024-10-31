<?php

namespace App\DataFixtures;

use App\Factory\CompanyFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user = UserFactory::createMany(3, ['roles' => ['ROLE_USER']]);

        $superAdmin = UserFactory::createOne([
            'email' => 'superadmin@test.com',
            'password' => 'password',
            'roles' => ['ROLE_SUPER_ADMIN'],
        ]);

        $company = CompanyFactory::createMany(5);
        $companyAdmin = UserFactory::createMany(5, ['roles' => ['ROLE_COMPANY_ADMIN'] , 'company' => CompanyFactory::random()]);

        $manager->flush();
    }
}
