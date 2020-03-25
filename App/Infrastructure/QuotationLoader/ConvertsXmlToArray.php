<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationLoader;

trait ConvertsXmlToArray
{
    private function xmlToArray(string $contents): array
    {
        return json_decode(json_encode(new \SimpleXMLElement($contents)), true);
    }
}
