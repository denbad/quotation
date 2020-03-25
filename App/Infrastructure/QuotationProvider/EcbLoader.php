<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationProvider;

final class EcbLoader extends BaseLoader
{
    use ConvertsXmlToArray;

    public function name(): string
    {
        return 'European Central Bank';
    }

    protected function uri(): string
    {
        return 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    }

    protected function code(): string
    {
        return 'EUR';
    }

    protected function normalize(string $contents): array
    {
        return array_map(function (array $entry): array {
            $entry = array_shift($entry);
            return [
                'base' => $this->code(),
                'quote' => $entry['currency'],
                'nominal' => 1,
                'bid' => $entry['rate']
            ];
        }, $this->xmlToArray($contents)['Cube']['Cube']['Cube']);
    }
}
