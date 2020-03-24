<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient;

final class EcbAdapter extends BaseAdapter
{
    use ConvertsXmlToArray;

    protected function uri(): string
    {
        return 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';
    }

    protected function base(): string
    {
        return 'EUR';
    }

    protected function normalize(string $contents): array
    {
        return array_map(function (array $entry): Entry {
            $entry = array_shift($entry);
            return new Entry($this->base(), $entry['currency'], 1, $entry['rate']);
        }, $this->xmlToArray($contents)['Cube']['Cube']['Cube']);
    }
}
