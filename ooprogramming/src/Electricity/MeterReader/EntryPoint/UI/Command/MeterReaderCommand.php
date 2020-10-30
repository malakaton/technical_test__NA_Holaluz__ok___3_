<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\EntryPoint\UI\Command;

use App\Electricity\MeterReader\Application\FindSuspiciousReading\MeterReaderFindSuspiciousReadCommand;
use App\Electricity\MeterReader\Domain\MeterReader;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

final class MeterReaderCommand extends Command
{
    private MessageBusInterface $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure(): void
    {
        $this
            ->setName('execute:electricity-meter-reader')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'The path of clients electricity meter reader'
            )
            ->addArgument(
                'source-type',
                InputArgument::REQUIRED,
                'The source type (should be file/url/ftp...) Only "file" type is implemented'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @var HandledStamp $envelope */
        $envelope = $this->commandBus->dispatch(
            new MeterReaderFindSuspiciousReadCommand(
                $input->getArgument('path'),
                $input->getArgument('source-type')
            )
        )->last(HandledStamp::class);

        $output->write(
            PHP_EOL . "<fg=black;bg=green><fg=black;bg=green>Client</>           </>"
        );
        $output->write(
            "<fg=black;bg=green><fg=black;bg=green>Month</>      </>"
        );
        $output->write(
            "<fg=black;bg=green><fg=black;bg=green>Suspicious</>   </>"
        );
        $output->write(
             "<fg=black;bg=green><fg=black;bg=green>Median</>   </>" . PHP_EOL
        );

        $output->write(
            "<fg=white;bg=green>--------------------------------------------------</>" . PHP_EOL
        );

        foreach ($envelope->getResult() as $meterReader) {
            /**@var MeterReader $meterReader **/
            $output->write(
                "<fg=black;bg=red><fg=black;bg=red></> {$meterReader->clientId()->value()} </>"
            );
            $output->write("<fg=black;bg=red><fg=black;bg=red></> {$meterReader->period()->date()}      </>");
            $output->write(
                "<fg=black;bg=red><fg=black;bg=red></> {$meterReader->reading()->value()}       </>"
            );
            $output->writeln("<fg=black;bg=red><fg=black;bg=red></> {$meterReader->median()->value()} </><fg=black;bg=red><fg=black;bg=red></> </>");
        }
        $output->write(PHP_EOL);

        return Command::SUCCESS;
    }
}