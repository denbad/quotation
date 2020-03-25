<?php

declare(strict_types=1);

namespace App\Domain;

use Assert\Assertion;

final class Quotation
{
    private string $base;
    private string $quote;
    private float $bid;

    public function __construct(string $base, string $quote, float $bid, int $nominal = 1)
    {
        Assertion::length($base, 3);
        Assertion::length($quote, 3);
        Assertion::greaterThan($bid, 0);
        Assertion::greaterThan($nominal, 0);

        $this->base = strtoupper($base);
        $this->quote = strtoupper($quote);
        $this->bid = $bid / $nominal;
    }

    public function isFlipable(): bool
    {
        return $this->base !== $this->quote;
    }

    public function flip(): self
    {
        if (!$this->isFlipable()) {
            throw ForbiddenOperation::notFlipable($this->code());
        }

        return new self($this->quote, $this->base, 1 / $this->bid);
    }

    public function isCrossable(self $quotation): bool
    {
        if ($this->quote !== $quotation->base()) {
            return false;
        }
        if ($this->equals($quotation)) {
            return false;
        }
        if ($this->base === $quotation->quote()) {
            return false;
        }

        return true;
    }

    public function cross(self $quotation): self
    {
        if (!$this->isCrossable($quotation)) {
            throw ForbiddenOperation::notCrossable($this->code(), $quotation->code());
        }

        return new self($this->base, $quotation->quote(), $this->bid * $quotation->bid());
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

    public function code(): string
    {
        return $this->base.$this->quote;
    }

    private function equals(self $quotation): bool
    {
        return $this->code() === $quotation->code();
    }
}
