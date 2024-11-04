<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

class CompanyTest extends KernelTestCase
{
    use HasBrowser;
    use ResetDatabase;

    public function testGetCollectionOfCompanies(): void
    {
        //todo: test all scenarios for company endPoint.
//        $this->browser()
//            ->get('/api/companies')
//            ->assertSuccessful();
    }

}