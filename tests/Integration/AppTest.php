<?php

declare(strict_types=1);

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class AppTest extends WebTestCase
{
    public function testWithMissingNominal(): void
    {
        $this->fail();
    }

    public function testWithMalformedNominal(): void
    {
        $this->fail();
    }

    public function testWhenNotSupported(): void
    {
        $this->fail();
    }

    public function test10EurToRub(): void
    {
        $this->fail();
    }

    public function test100RubToEur(): void
    {
        $this->fail();
    }

    public function test1ZdrToUzs(): void
    {
        $this->fail();
    }
}
