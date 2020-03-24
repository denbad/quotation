<?php

declare(strict_types=1);

namespace App\Application;

final class Refresh
{
    private $base;
    private $quote;
    private $bid;
    private $nominal;

    public function __construct(string $base, string $quote, int $nominal, float $bid)
    {
        $this->base = $base;
        $this->quote = $quote;
        $this->nominal = $nominal;
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

    public function nominal(): int
    {
        return $this->nominal;
    }

    public function bid(): float
    {
        return $this->bid;
    }
}
