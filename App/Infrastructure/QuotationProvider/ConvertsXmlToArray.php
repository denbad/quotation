<?php

declare(strict_types=1);

namespace App\Infrastructure\QuotationProvider;

use SimpleXMLElement;

trait ConvertsXmlToArray
{
    private function xmlToArray(string $contents): array
    {
        $contents = json_encode(new SimpleXMLElement($contents), JSON_THROW_ON_ERROR);
        return json_decode($contents, true, 512, JSON_THROW_ON_ERROR);
    }
}
