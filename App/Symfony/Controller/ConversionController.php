<?php

declare(strict_types=1);

namespace App\Symfony\Controller;

use App\Application\Query\Convert;
use App\Application\Query\ConvertHandler;
use App\Application\Query\NotFound;
use App\Application\Query\NotValid;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Throwable;

final class ConversionController
{
    public function __invoke(Request $request, string $code, ConvertHandler $handler): Response
    {
        try {
            return new JsonResponse($handler(new Convert($code, $request->query->get('nominal', ''))));
        } catch (NotValid $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (NotFound $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (Throwable $exception) {
            return new JsonResponse(['error' => 'Internal server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
