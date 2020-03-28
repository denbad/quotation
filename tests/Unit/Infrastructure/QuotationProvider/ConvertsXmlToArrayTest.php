<?php

declare(strict_types=1);

namespace App\Tests\Unit\Infrastructure\QuotationProvider;

use App\Infrastructure\QuotationProvider\ConvertsXmlToArray;
use PHPUnit\Framework\TestCase;

final class ConvertsXmlToArrayTest extends TestCase
{
    public function testXmlToArray(): void
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><note><to>To</to><from>From</from><heading>Foo</heading></note>';
        $array  = (new Sut())->doXmlToArray($xml);

        $this->assertEquals($array, [
            'to' => 'To',
            'from' => 'From',
            'heading' => 'Foo',
        ]);
    }
}

final class Sut
{
    use ConvertsXmlToArray;

    public function doXmlToArray(string $contents): array
    {
        return $this->xmlToArray($contents);
    }
}
