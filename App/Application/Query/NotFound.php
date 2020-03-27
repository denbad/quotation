<?php

declare(strict_types=1);

namespace App\Application\Query;

use RuntimeException;

final class NotFound extends RuntimeException
{
    public static function notSupported(): self
    {
        return new self('Currency code not supported');
    }
}
