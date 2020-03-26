<?php

declare(strict_types=1);

namespace App\Application\Query;

final class NotFound extends \RuntimeException
{
    public static function notSupported(string $code): self
    {
        return new self('Currency code not supported');
    }
}
