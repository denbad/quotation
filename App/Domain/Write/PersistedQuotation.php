<?php

declare(strict_types=1);

namespace App\Domain\Write;

use Assert\Assertion;
use DateTimeImmutable;

class PersistedQuotation
{
    private string $id;
    private float $bid;
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function __construct(string $code, float $bid)
    {
        Assertion::length($code, 6);
        Assertion::greaterThan($bid, 0);

        $this->id = $code;
        $this->bid = $bid;
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    public function refresh(float $bid): void
    {
        $this->bid = $bid;
        $this->updatedAt = new DateTimeImmutable();
    }

    public function equals(self $quotation): bool
    {
        return $this->code() === $quotation->code() && $this->bid === $quotation->bid();
    }

    public function code(): string
    {
        return $this->id;
    }

    public function bid(): float
    {
        return $this->bid;
    }
}
