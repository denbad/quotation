<?php

declare(strict_types=1);

namespace App\Infrastructure\HttpClient;

final class CbrAdapter extends BaseAdapter
{
    use ConvertsXmlToArray;

    protected function uri(): string
    {
        return 'https://www.cbr.ru/scripts/XML_daily.asp';
    }

    protected function base(): string
    {
        return 'RUB';
    }

    protected function normalize(string $contents): array
    {
        return array_map(function (array $entry): Entry {
            return new Entry(
                $this->base(),
                $entry['CharCode'],
                $entry['Nominal'],
                str_replace(',', '.', $entry['Value'])
            );
        }, $this->xmlToArray($contents)['Valute']);
    }
}
