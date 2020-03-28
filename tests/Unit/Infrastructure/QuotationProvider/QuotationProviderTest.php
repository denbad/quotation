<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\QuotationProvider;

use App\Domain\Write\Quotation;
use App\Infrastructure\QuotationProvider\QuotationProvider;
use App\Infrastructure\QuotationProvider\Loader;
use PHPUnit\Framework\TestCase;

final class QuotationProviderTest extends TestCase
{
    public function testQuotations(): void
    {
        $loader = $this->getMockBuilder(Loader::class)->getMock();

        $loader
            ->expects($this->any())
            ->method('load')
            ->willReturn([
                [
                    'base' => 'EUR',
                    'quote' => 'USD',
                    'nominal' => '1',
                    'bid' => '1.0977'
                ],
                [
                    'base' => 'EUR',
                    'quote' => 'JPY',
                    'nominal' => '1',
                    'bid' => '119.36'
                ],
            ])
        ;

        $provider = new QuotationProvider($loader);

        $this->assertEquals($provider->quotations(), [
            'EURUSD' => new Quotation('EUR', 'USD', 1.0977),
            'EURJPY' => new Quotation('EUR', 'JPY', 119.36),
            'USDEUR' => new Quotation('USD', 'EUR', 0.91099571832012),
            'JPYEUR' => new Quotation('JPY', 'EUR', 0.0083780160857909),
            'USDJPY' => new Quotation('USD', 'JPY', 108.73644893869),
            'JPYUSD' => new Quotation('JPY', 'USD', 0.0091965482573727)
        ]);
    }
}


