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
    public function __invoke(Request $request, string $code, ConvertHandler $handler): Response
    {
        return new JsonResponse(...$handler(new Convert($code, $request->query->get('amount'))));
    }
}
