<?php

declare(strict_types=1);

namespace App\Application\Query;

use RuntimeException;

final class NotValid extends RuntimeException
{
    private array $violations;

    public function __construct($violations)
    {
        parent::__construct('Not valid');

        $this->violations = $violations;
    }

    public function violations(): array
    {
        return $this->violations;
    }
}
