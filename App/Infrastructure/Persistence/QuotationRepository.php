<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Read\Quotation;
use App\Domain\Read\QuotationRepository as ReadRepository;
use Doctrine\DBAL\Connection;

final class QuotationRepository implements ReadRepository
{
    private Connection $conn;

    public function __construct(Connection $conn)
    {
        $this->conn = $conn;
    }

    public function byCode(string $code): ?Quotation
    {
        $qb = $this->conn->createQueryBuilder()
            ->select('id, bid, updated_at')
            ->from('quotation')
            ->where('id = :code')
            ->setParameter('code', $code)
        ;

        if ($data = $qb->execute()->fetch()) {
            return Quotation::create($data['id'], (float) $data['bid'], $data['updated_at']);
        }

        return null;
    }
}
