<?php

declare(strict_types=1);

namespace App\Symfony\Controller;

use App\Application\Query\Convert;
use App\Application\Query\ConvertHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

final class ConversionController
{
    private ConvertHandler $handler;

    public function __construct(ConvertHandler $handler)
    {
        $this->handler = $handler;
    }

    public function __invoke(Request $request, string $code): Response
    {
        return new JsonResponse(...$this->handler->handle(new Convert($code, $request->query->get('amount'))));
    }
}
