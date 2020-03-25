<?php

declare(strict_types=1);

namespace App\Symfony\Command;

use App\Application\Refresh;
use App\Domain\Quotation;
use App\Domain\QuotationProvider;
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
            ->addOption('dry-run', null, InputOption::VALUE_NONE)
            ->addOption('force', null, InputOption::VALUE_NONE)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): ?int
    {
        if (!$input->getOption('force')) {
            $message = '<info>Proceed with quotation sync</info> ? (Y/n)';
            if (!$this->getHelper('question')->ask($input, $output, new ConfirmationQuestion($message, false))) {
                $output->writeln('<error>Quotation sync canceled!</error>');
                return 0;
            }
        }

        $output->writeln('<comment>Loading...</comment>');

        $entries = $this->provider->entries();

        if ($input->getOption('dry-run')) {
            (new Table($output))
                ->setHeaders(['Base', 'Quote', 'Bid', 'Nominal'])
                ->addRows(array_map(static function (Quotation $entry): array {
                    return [$entry->base, $entry->quote, $entry->nominal, $entry->bid];
                }, $entries))
                ->render()
            ;

            return 0;
        }

        $output->writeln('<comment>Saving...</comment>');

        array_walk($entries, function (Quotation $entry): void {
            $this->commandBus->handle(new Refresh(
                (string) $entry->base,
                (string) $entry->quote,
                (int) $entry->nominal,
                (float) $entry->bid
            ));
        });

        $output->writeln('<comment>Done.</comment>');

        return 0;
    }
}
