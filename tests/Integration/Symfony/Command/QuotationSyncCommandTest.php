<?php

declare(strict_types=1);

namespace App\Tests\Integration\Symfony\Command;

use App\Domain\Write\QuotationProvider;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

final class QuotationSyncCommandTest extends KernelTestCase
{
    public function testExecuteEcb(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('quotation:sync');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            '--loader' => QuotationProvider::LOADER_ECB,
            '--force' => true,
            '--dry-run' => true,
        ]);
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('EURSEK', $output);
        $this->assertStringContainsString('ZARTHB', $output);
    }

    public function testExecuteCbr(): void
    {
        $kernel = static::createKernel();
        $application = new Application($kernel);

        $command = $application->find('quotation:sync');
        $commandTester = new CommandTester($command);

        $commandTester->execute([
            '--loader' => QuotationProvider::LOADER_CBR,
            '--force' => true,
            '--dry-run' => true,
        ]);
        $output = $commandTester->getDisplay();

        $this->assertStringContainsString('GBPUSD', $output);
        $this->assertStringContainsString('JPYKRW', $output);
    }
}
