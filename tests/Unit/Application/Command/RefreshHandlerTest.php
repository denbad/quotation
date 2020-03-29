<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Command;

use App\Application\Command\Refresh;
use App\Application\Command\RefreshHandler;
use App\Domain\Write\PersistedQuotation;
use App\Domain\Write\PersistedQuotationRepository;
use PHPUnit\Framework\TestCase;

final class RefreshHandlerTest extends TestCase
{
    private array $messages;
    private $quotations;
    private RefreshHandler $handler;

    public function testInvokeCreate(): void
    {
        $code = 'AAABBB';
        $bid = 7.99;

        $this->quotations
            ->expects($this->any())
            ->method('byCode')
            ->with($code)
            ->willReturn(null)
        ;

        $this->quotations
            ->expects($this->any())
            ->method('save')
            ->willReturnCallback(fn (PersistedQuotation $quotation) => $this->messages['created'] = $quotation)
        ;

        call_user_func($this->handler, new Refresh($code, $bid));

        $this->assertTrue(($this->createQuotation($code, $bid)->equals($this->messages['created'])));
    }

    public function testInvokeRefresh(): void
    {
        $code = 'AAABBB';
        $refreshedBid = 8.99;
        $quotation = $this->createQuotation($code, 7.99);

        $this->quotations
            ->expects($this->any())
            ->method('byCode')
            ->with($code)
            ->willReturn($quotation)
        ;

        $this->quotations
            ->expects($this->any())
            ->method('save')
            ->willReturnCallback(fn (PersistedQuotation $quotation) => $this->messages['refreshed'] = $quotation)
        ;

        call_user_func($this->handler, new Refresh($code, $refreshedBid));

        $this->assertTrue(($this->createQuotation($code, $refreshedBid)->equals($this->messages['refreshed'])));
    }

    protected function setUp(): void
    {
        $this->messages = [];
        $this->quotations = $this->getMockBuilder(PersistedQuotationRepository::class)->getMock();

        /** @var PersistedQuotationRepository $quotations */
        $quotations = $this->quotations;

        $this->handler = new RefreshHandler($quotations);
    }

    private function createQuotation(string $code, float $bid): PersistedQuotation
    {
        return new PersistedQuotation($code, $bid);
    }
}
