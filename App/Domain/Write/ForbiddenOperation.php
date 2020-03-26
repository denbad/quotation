<?php

declare(strict_types=1);

namespace App\Domain\Write;

final class ForbiddenOperation extends \LogicException
{
    public static function notFlipable(string $code): self
    {
        return new self(sprintf('Quotation %s is not flipable.', $code));
    }

    public static function notCrossable(string $codeA, string $codeB): self
    {
        return new self(sprintf('Quotation %s is not crossable with %s.', $codeA, $codeB));
    }
}
