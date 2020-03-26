<?php

declare(strict_types=1);

namespace App\Application\Query;

use App\Domain\Read\ConversionRepository;

final class ConvertHandler
{
    private const HTTP_OK = 200;
    private const HTTP_BAD_REQUEST = 400;
    private const HTTP_NOT_FOUND = 404;
    private const HTTP_INTERNAL_SERVER_ERROR = 500;

    private ConversionRepository $conversions;

    public function __construct(ConversionRepository $conversions)
    {
        $this->conversions = $conversions;
    }

    public function handle(Convert $query): array
    {
        if (!$amount = $query->amount()) {
            return [['error' => 'Empty amount'], self::HTTP_BAD_REQUEST];
        }
        if (!preg_match('#^([\d]+([.][\d]*)?|[.][\d]+)$#', $amount)) {
            return [['error' => 'Malformed amount'], self::HTTP_BAD_REQUEST];
        }

        try {
            if (!$conversion = $this->conversions->byCode($query->code())) {
                return [['error' => 'Not supported'], self::HTTP_NOT_FOUND];
            }

            return [
                [
                    'result' => [
                        'code' => $conversion->code(),
                        'bid' => $conversion->bid(),
                        'effectiveFrom' => $conversion->effectiveFrom(),
                        'price' => $conversion->price((float) $amount)
                    ]
                ],
                self::HTTP_OK
            ];
        } catch (\Throwable $exception) {
            return [['error' => 'Server error'], self::HTTP_INTERNAL_SERVER_ERROR];
        }
    }
}
