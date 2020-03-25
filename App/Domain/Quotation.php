<?php

declare(strict_types=1);

namespace App\Domain;

final class Quotation
{
    private string $base;
    private string $quote;
    private float $bid;

    private function __construct(string $base, string $quote, float $bid)
    {
        $this->base = strtoupper($base);
        $this->quote = strtoupper($quote);
        $this->bid = $bid;
    }

    public static function create(string $base, string $quote, float $bid): self
    {
        return new self($base, $quote, $bid);
    }

    public function code(): string
    {
        return sprintf('%s%s', $this->base, $this->quote);
    }

    public function bid(): float
    {
        return $this->bid;
    }
}
