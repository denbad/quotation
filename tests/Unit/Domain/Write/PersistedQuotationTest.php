<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Write;

use App\Domain\Write\PersistedQuotation;
use PHPUnit\Framework\TestCase;

final class PersistedQuotationTest extends TestCase
{
    public function testRefresh(): void
    {
        $bid = 11.99;
        $quotation = new PersistedQuotation('XXXZZZ', 10.99);
        $quotation->refresh($bid);

        $this->assertEquals($bid, $quotation->bid());
    }

    public function testEquals(): void
    {
        $quotationA = new PersistedQuotation('XXXZZZ', 10.99);
        $quotationB = new PersistedQuotation('XXXZZZ', 10.99);

        $this->assertTrue($quotationA->equals($quotationB));
    }

    public function testNotEqualsByCode(): void
    {
        $quotationA = new PersistedQuotation('XXXZZZ', 10.99);
        $quotationB = new PersistedQuotation('AAABBB', 10.99);

        $this->assertFalse($quotationA->equals($quotationB));
    }

    public function testNotEqualsByBid(): void
    {
        $quotationA = new PersistedQuotation('XXXZZZ', 10.99);
        $quotationB = new PersistedQuotation('XXXZZZ', 11.99);

        $this->assertFalse($quotationA->equals($quotationB));
    }
}
