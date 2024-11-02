<?php

namespace App\DataFixtures;

use App\Factory\ApiTokenFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user = UserFactory::createMany(10);
        $superAdmin = UserFactory::createOne([
            'email' => 'superadmin@test.com',
            'password' => 'password',
            'roles' => ['ROLE_SUPER_ADMIN'],
        ]);

        ApiTokenFactory::createMany(30, function () {
            return [
                'ownedBy' => UserFactory::random()
            ];
        });


        $manager->flush();
    }
}
