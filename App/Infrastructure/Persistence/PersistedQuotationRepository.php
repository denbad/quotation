<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Write\PersistedQuotation;
use App\Domain\Write\PersistedQuotationRepository as WriteRepository;
use Assert\Assertion;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

final class PersistedQuotationRepository implements WriteRepository
{
    private ManagerRegistry $managerRegistry;
    private string $class;

    public function __construct(ManagerRegistry $managerRegistry, string $class)
    {
        $this->managerRegistry = $managerRegistry;
        $this->class = $class;
    }

    public function byCode(string $code): ?PersistedQuotation
    {
        /** @var PersistedQuotation $quotation */
        $quotation = $this->getRepository()->find($code);

        return $quotation;
    }

    public function save(PersistedQuotation $quotation): void
    {
        /** @var EntityManager $manager */
        $manager = $this->getManager();

        $manager->persist($quotation);
        $manager->flush($quotation);
    }

    private function getManager(): ObjectManager
    {
        /** @var ObjectManager $manager */
        $manager = $this->managerRegistry->getManagerForClass($this->class);

        Assertion::notNull($manager);

        return $manager;
    }

    private function getRepository(): ObjectRepository
    {
        return $this->getManager()->getRepository($this->class);
    }
}
