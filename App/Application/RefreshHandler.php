<?php

declare(strict_types=1);

namespace App\Application;

final class RefreshHandler
{
    public function __invoke(Refresh $command): void
    {
        dump(__METHOD__); die;
    }
}
