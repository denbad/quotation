<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationProvider;

final class CbrLoader extends BaseLoader
{
    use ConvertsXmlToArray;

    public function name(): string
    {
        return 'The Central Bank of the Russian Federation';
    }

    protected function uri(): string
    {
        return 'https://www.cbr.ru/scripts/XML_daily.asp';
    }

    protected function code(): string
    {
        return 'RUB';
    }

    protected function normalize(string $contents): array
    {
        return array_map(function (array $entry): array {
            return [
                'base' => $entry['CharCode'],
                'quote' => $this->code(),
                'nominal' => $entry['Nominal'],
                'bid' => str_replace(',', '.', $entry['Value']),
            ];
        }, $this->xmlToArray($contents)['Valute']);
    }
}
