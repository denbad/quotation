<?php

declare(strict_types=1);

namespace App\Application\Query;

use RuntimeException;
use Throwable;

final class NotFound extends RuntimeException
{
    public function __construct($code = 0, Throwable $previous = null)
    {
        parent::__construct('Currency code not supported', $code, $previous);
    }
}
