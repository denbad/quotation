<?php

declare(strict_types=1);

namespace App\Application\Command;

final class Refresh
{
    private string $code;
    private float $bid;

    public function __construct(string $code, float $bid)
    {
        $this->code = $code;
        $this->bid = $bid;
    }

    public function code(): string
    {
        return $this->code;
    }

    public function bid(): float
    {
        return $this->bid;
    }
}
