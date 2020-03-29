<?php

declare(strict_types=1);

namespace App\Symfony\Controller;

use App\Application\Query\Convert;
use App\Application\Query\ConvertHandler;
use App\Application\Query\NotFound;
use App\Application\Query\NotValid;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class ConversionController
{
    public function __invoke(Request $request, string $code, ConvertHandler $handler): Response
    {
        try {
            $httpCode = Response::HTTP_OK;
            $body = $handler(new Convert($code, $request->query->get('nominal', '')));
        } catch (NotValid $exception) {
            $httpCode = Response::HTTP_BAD_REQUEST;
            $body = $exception->violations();
        } catch (NotFound $exception) {
            $httpCode = Response::HTTP_NOT_FOUND;
            $body = $exception->getMessage();
        } catch (Throwable $exception) {
            $httpCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            $body = 'Internal server error';
        }

        return new JsonResponse([$httpCode => $body], $httpCode);
    }
}
