<?php

namespace App\Tests\Shared\Infrastructure\PhpUnit;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTestCase extends KernelTestCase
{
    /** @var Application */
    protected Application $application;

    protected function setUp(): void
    {
        parent::setUp();

        $kernel = static::createKernel();
        $this->application = new Application($kernel);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
