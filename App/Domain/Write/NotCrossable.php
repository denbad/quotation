<?php

declare(strict_types=1);

namespace App\Domain\Write;

use LogicException;

final class NotCrossable extends LogicException
{
    public function __construct(string $codeA, string $codeB)
    {
        parent::__construct(sprintf('Quotation %s is not crossable with %s', $codeA, $codeB));
    }
}
