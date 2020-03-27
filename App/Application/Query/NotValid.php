<?php

declare(strict_types=1);

namespace App\Application\Query;

use RuntimeException;
use Throwable;

final class NotValid extends RuntimeException
{
    private array $violations;

    public function __construct($violations, $message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->violations = $violations;
    }

    public function violations(): array
    {
        return $this->violations;
    }
}
