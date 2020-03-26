<?php

declare(strict_types=1);

namespace App\Application\Query;

final class NotValid extends \RuntimeException
{
    public static function emptyNominal(): self
    {
        return new self('Empty or missing "nominal" parameter.');
    }

    public static function malformedNominal(string $nominal): self
    {
        return new self(sprintf('Malformed "nominal" parameter: "%s".', $nominal));
    }
}
