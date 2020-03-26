<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Read\Conversion;
use App\Domain\Read\ConversionRepository as ReadRepository;
use Doctrine\DBAL\Connection;

final class ConversionRepository implements ReadRepository
{
    private Connection $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function byCode(string $code): ?Conversion
    {
        $qb = $this->conn->createQueryBuilder()
            ->select('code, bid, updatedAt')
            ->from('quotation')
            ->where('id = :code')
            ->setParameter('code', $code)
        ;

        if ($data = $qb->execute()->fetch()) {
            return new Conversion($data['code'], $data['bid'], $data['updatedAt']);
        }

        return null;
    }
}
