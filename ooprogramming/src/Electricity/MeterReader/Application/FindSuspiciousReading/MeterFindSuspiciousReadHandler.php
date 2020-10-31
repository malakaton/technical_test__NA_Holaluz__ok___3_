<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Application\FindSuspiciousReading;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use App\Electricity\MeterReader\Domain\Exception\ClientIdNotDefined;

final class MeterFindSuspiciousReadHandler implements MessageHandlerInterface
{
    private MeterReaderSuspiciousFinder $finder;

    public function __construct(MeterReaderSuspiciousFinder $finder)
    {
        $this->finder = $finder;
    }

    /**
     * @param MeterReaderFindSuspiciousReadCommand $command
     * @return array|null
     * @throws ClientIdNotDefined
     */
    public function __invoke(MeterReaderFindSuspiciousReadCommand $command): ?array
    {
        return $this->finder->find($command->path(), $command->sourceType());
    }
}