<?php

declare(strict_types=1);

namespace App\Domain\Write;

use LogicException;

final class NotFlipable extends LogicException
{
    public function __construct(string $code)
    {
        parent::__construct(sprintf('Quotation %s is not flipable', $code));
    }
}
