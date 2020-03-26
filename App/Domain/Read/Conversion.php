<?php

declare(strict_types=1);

namespace App\Domain\Read;

final class Conversion
{
    private string $code;
    private float $bid;
    private string $effectiveFrom;

    public function __construct(string $code, float $bid, string $effectiveFrom)
    {
        $this->code = $code;
        $this->bid = $bid;
        $this->effectiveFrom = $effectiveFrom;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function bid(): float
    {
        return $this->bid;
    }

    public function effectiveFrom(): string
    {
        return $this->effectiveFrom;
    }

    public function price(float $amount): float
    {
        return $amount * $this->bid;
    }
}
