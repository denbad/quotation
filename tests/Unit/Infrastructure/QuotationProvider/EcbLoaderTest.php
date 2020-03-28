<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\QuotationProvider;

use App\Infrastructure\QuotationProvider\EcbLoader;
use App\Infrastructure\QuotationProvider\Loader;
use GuzzleHttp\ClientInterface;

final class EcbLoaderTest extends BaseLoaderTest
{
    protected function requestArguments(): array
    {
        return ['GET', 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml'];
    }

    protected function loader(ClientInterface $client): Loader
    {
        return new EcbLoader($client);
    }

    protected function contents(): string
    {
        return file_get_contents(__DIR__ . '/ecbResponse.xml');
    }

    protected function expected(): array
    {
        return [
            'base' => 'EUR',
            'quote' => 'JPY',
            'nominal' => '1',
            'bid' => '119.36'
        ];
    }
}
