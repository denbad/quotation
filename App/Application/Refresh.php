<?php

declare(strict_types=1);

namespace App\Application;

final class Refresh
{
    private string $base;
    private string $quote;
    private float $bid;

    public function __construct(string $base, string $quote, float $bid)
    {
        $this->base = $base;
        $this->quote = $quote;
        $this->bid = $bid;
    }

    public function base(): string
    {
        return $this->base;
    }

    public function quote(): string
    {
        return $this->quote;
    }

    public function bid(): float
    {
        return $this->bid;
    }
}
