<?php

declare(strict_types=1);

namespace App\Application;

final class ConvertHandler
{
    public function __invoke(Convert $command): void
    {
        dump(__METHOD__); die;
    }
}
