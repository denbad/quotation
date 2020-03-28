<?php

declare(strict_types=1);

namespace App\Domain\Read;

use Assert\Assertion;

final class Quotation
{
    private string $code;
    private float $bid;
    private float $nominal;
    private string $effectiveFrom;

    private function __construct(string $code, float $bid, float $nominal, string $effectiveFrom)
    {
        Assertion::length($code, 6);
        Assertion::greaterThan($bid, 0);
        Assertion::greaterThan($nominal, 0);

        $this->code = $code;
        $this->bid = $bid;
        $this->nominal = $nominal;
        $this->effectiveFrom = $effectiveFrom;
    }

    public static function create(string $code, float $bid, string $effectiveFrom): self
    {
        return new self($code, $bid, 1.0, $effectiveFrom);
    }

    public function convert(float $nominal): self
    {
        return new self($this->code, $this->bid * $nominal, $nominal, $this->effectiveFrom);
    }

    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'bid' => $this->bid,
            'nominal' => $this->nominal,
            'effectiveFrom' => $this->effectiveFrom,
        ];
    }
}
