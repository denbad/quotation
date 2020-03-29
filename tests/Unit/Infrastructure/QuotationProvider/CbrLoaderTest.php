<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\QuotationProvider;

use App\Infrastructure\QuotationProvider\CbrLoader;
use App\Infrastructure\QuotationProvider\Loader;
use GuzzleHttp\ClientInterface;

final class CbrLoaderTest extends BaseLoaderTest
{
    protected function requestArguments(): array
    {
        return ['GET', 'https://www.cbr.ru/scripts/XML_daily.asp'];
    }

    protected function loader(ClientInterface $client): Loader
    {
        return new CbrLoader($client);
    }

    protected function contents(): string
    {
        return (string) file_get_contents(__DIR__.'/cbrResponse.xml');
    }

    protected function expected(): array
    {
        return [
            'base' => 'JPY',
            'quote' => 'RUB',
            'nominal' => '100',
            'bid' => '71.4027',
        ];
    }
}
