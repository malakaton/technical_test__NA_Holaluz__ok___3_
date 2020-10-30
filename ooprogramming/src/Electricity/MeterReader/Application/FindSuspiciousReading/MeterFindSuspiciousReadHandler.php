<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Application\FindSuspiciousReading;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Electricity\MeterReader\Domain\ClientIDNotDefined;

final class MeterFindSuspiciousReadHandler implements MessageHandlerInterface
{
    private MeterReaderSuspiciousFinder $finder;

    public function __construct(MeterReaderSuspiciousFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param MeterReaderFindSuspiciousReadCommand $command
     * @return array
     * @throws ClientIDNotDefined
     */
    public function __invoke(MeterReaderFindSuspiciousReadCommand $command): ?array
    {
        return $this->finder->find($command->path(), $command->sourceType());
    }
}