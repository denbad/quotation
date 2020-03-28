<?php

declare(strict_types=1);

namespace App\Tests\Unit\Domain\Read;

use App\Domain\Read\Quotation;
use PHPUnit\Framework\TestCase;

final class QuotationTest extends TestCase
{
    public function testToArray(): void
    {
        $data = [
            'code' => 'XXXZZZ',
            'bid' => 10.00,
            'nominal' => 1,
            'effectiveFrom' => '2020-03-26 06:01:26'
        ];
        $quotation = Quotation::create($data['code'], $data['bid'], $data['effectiveFrom']);

        $this->assertEquals($quotation->toArray(), $data);
    }
}
