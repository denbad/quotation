<?php

declare(strict_types=1);

namespace App\Symfony\Command;

use App\Application\Command\Refresh;
use App\Domain\Write\Quotation;
use App\Domain\Write\QuotationProvider;
use SimpleBus\Message\Bus\MessageBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;

final class QuotationSyncCommand extends Command
{
    protected static $defaultName = 'quotation:sync';
    private QuotationProvider $provider;
    private MessageBus $commandBus;

    public function __construct(QuotationProvider $provider, MessageBus $commandBus)
    {
        parent::__construct();

        $this->provider = $provider;
        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->addOption('loader', null, InputOption::VALUE_REQUIRED, '', QuotationProvider::LOADER_DEFAULT)
            ->addOption('dry-run', null, InputOption::VALUE_NONE)
            ->addOption('force', null, InputOption::VALUE_NONE)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        /** @var string $loader */
        $loader = $input->getOption('loader');

        if (!$input->getOption('force')) {
            $provider = $this->provider->name($loader);
            $message = sprintf('<info>Proceed with sync from <comment>"%s"</comment></info> ? (Y/n)', $provider);
            if (!$this->getHelper('question')->ask($input, $output, new ConfirmationQuestion($message, false))) {
                $output->writeln('<error>Quotation sync canceled!</error>');

                return 0;
            }
        }

        $output->writeln('<comment>Loading...</comment>');

        $quotations = $this->provider->quotations($loader);

        if ($input->getOption('dry-run')) {
            (new Table($output))
                ->setHeaders(['Code', 'Bid'])
                ->addRows(array_map(static function (Quotation $quotation): array {
                    return [$quotation->code(), $quotation->bid()];
                }, $quotations))
                ->render()
            ;

            return 0;
        }

        $output->writeln('<comment>Saving...</comment>');

        array_walk($quotations, function (Quotation $quotation): void {
            $this->commandBus->handle(new Refresh($quotation->code(), $quotation->bid()));
        });

        $output->writeln('<comment>Done.</comment>');

        return 0;
    }
}
