<?php

declare(strict_types=1);

namespace App\Tests\Unit\Application\Query;

use App\Application\Query\Convert;
use App\Application\Query\ConvertHandler;
use App\Application\Query\NotFound;
use App\Application\Query\NotValid;
use App\Domain\Read\Quotation;
use App\Domain\Read\QuotationRepository;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PropertyAccess\PropertyAccessor;
use Symfony\Component\Validator\Validation;

final class ConvertHandlerTest extends TestCase
{
    private $quotations;
    private ConvertHandler $handler;

    public function testInvokeNotValid(): void
    {
        $this->expectException(NotValid::class);
        call_user_func($this->handler, new Convert('XXXYYY', 'not_valid'));
    }

    public function testInvokeNotFound(): void
    {
        $code = 'XXXYYY';

        $this->quotations
            ->expects($this->any())
            ->method('byCode')
            ->with($code)
            ->willReturn(null)
        ;

        $this->expectException(NotFound::class);
        call_user_func($this->handler, new Convert($code, '10.99'));
    }

    public function testInvoke(): void
    {
        $code = 'XXXYYY';

        $this->quotations
            ->expects($this->any())
            ->method('byCode')
            ->with($code)
            ->willReturn(Quotation::create($code, 10.0, '2020-03-26 06:01:26'))
        ;

        $this->assertIsArray(call_user_func($this->handler, new Convert($code, '10.99')));
    }

    protected function setUp(): void
    {
        $this->quotations = $this->getMockBuilder(QuotationRepository::class)->getMock();

        /** @var QuotationRepository $quotations */
        $quotations = $this->quotations;

        $this->handler = new ConvertHandler($quotations, Validation::createValidator(), new PropertyAccessor());
    }
}
