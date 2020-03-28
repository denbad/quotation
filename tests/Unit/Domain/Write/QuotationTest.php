<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Write;

use App\Domain\Write\Quotation;
use App\Domain\Write\NotCrossable;
use App\Domain\Write\NotFlipable;
use PHPUnit\Framework\TestCase;

final class QuotationTest extends TestCase
{
    public function testConstruct(): void
    {
        $base = 'xxx';
        $quote = 'zzz';
        $quotation = new Quotation($base, $quote, 200.0, 10);

        $this->assertEquals('XXX', $quotation->base());
        $this->assertEquals('ZZZ', $quotation->quote());
        $this->assertEquals(20.0, $quotation->bid());
    }

    public function testCode(): void
    {
        $base = 'xxx';
        $quote = 'zzz';
        $quotation = new Quotation($base, $quote, 200.0, 10);

        $this->assertEquals('XXXZZZ', $quotation->code());
    }

    public function testIsFlipableFalse(): void
    {
        $quotation = new Quotation('XXX', 'XXX', 200.0, 10);
        $this->assertFalse($quotation->isFlipable());
    }

    public function testIsFlipableTrue(): void
    {
        $quotation = new Quotation('XXX', 'ZZZ', 200.0, 10);
        $this->assertTrue($quotation->isFlipable());
    }

    public function testFlipFail(): void
    {
        $this->expectException(NotFlipable::class);
        $quotation = new Quotation('XXX', 'XXX', 200.0, 10);
        $quotation->flip();
    }

    public function testFlipSuccess(): void
    {
        $base = 'XXX';
        $quote = 'ZZZ';

        $quotationA = new Quotation($base, $quote, 200.0, 10);
        $quotationB = $quotationA->flip();

        $this->assertEquals('ZZZ', $quotationB->base());
        $this->assertEquals('XXX', $quotationB->quote());
        $this->assertEquals(0.05, $quotationB->bid());
    }

    public function testIsCrossableFalseByQuote(): void
    {
        $quotationA = new Quotation('EUR', 'RUB', 10, 1);
        $quotationB = new Quotation('USD', 'RUB', 11, 1);

        $this->assertFalse($quotationA->isCrossable($quotationB));
    }

    public function testIsCrossableFalseByCode(): void
    {
        $quotationA = new Quotation('EUR', 'RUB', 10, 1);
        $quotationB = new Quotation('EUR', 'RUB', 10, 1);

        $this->assertFalse($quotationA->isCrossable($quotationB));
    }

    public function testIsCrossableFalseByBase(): void
    {
        $quotationA = new Quotation('EUR', 'RUB', 10, 1);
        $quotationB = new Quotation('USD', 'EUR', 1.1, 1);

        $this->assertFalse($quotationA->isCrossable($quotationB));
    }

    public function testIsCrossableTrue(): void
    {
        $quotationA = new Quotation('EUR', 'RUB', 10, 1);
        $quotationB = new Quotation('RUB', 'UAH', 3, 1);

        $this->assertTrue($quotationA->isCrossable($quotationB));
    }

    public function testCrossFail(): void
    {
        $quotationA = new Quotation('EUR', 'RUB', 10, 1);
        $quotationB = new Quotation('USD', 'RUB', 11, 1);

        $this->expectException(NotCrossable::class);
        $quotationA->cross($quotationB);
    }

    public function testCrossSuccess(): void
    {
        $quotationA = new Quotation('EUR', 'RUB', 87.98, 1);
        $quotationB = new Quotation('RUB', 'UAH', 0.36, 1);
        $quotationC = $quotationA->cross($quotationB);

        $this->assertEquals('EUR', $quotationC->base());
        $this->assertEquals('UAH', $quotationC->quote());
        $this->assertEquals(31.6728, $quotationC->bid());
    }
}
