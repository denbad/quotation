<?php

declare(strict_types=1);

namespace App\Application\Query;

use RuntimeException;

final class NotValid extends RuntimeException
{
    public static function emptyNominal(): self
    {
        return new self('Empty or missing parameter: nominal');
    }

    public static function malformedNominal(): self
    {
        return new self('Malformed parameter: nominal',);
    }
}
