<?php

declare(strict_types=1);

namespace App\Application\Query;

use RuntimeException;

final class NotFound extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Currency code not supported');
    }
}
