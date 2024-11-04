<?php

namespace App\Tests\Functional;

use App\Factory\CompanyFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

class CompanyTest extends KernelTestCase
{
    use HasBrowser;
    use ResetDatabase;

    public function testGetCollectionOfCompanies(): void
    {
        CompanyFactory::createMany(5);
        $json = $this->browser()
            ->get('/api/companies')
            ->assertJson()
            ->assertJsonMatches('"hydra:totalItems"', 5)
            ->assertJsonMatches('length("hydra:member")', 5)
            ->json()
        ;

        $this->assertSame(array_keys($json->decoded()['hydra:member'][0]), [
            "@id",
            "@type",
            "id",
            "name",
            "users",
        ]);
    }

}