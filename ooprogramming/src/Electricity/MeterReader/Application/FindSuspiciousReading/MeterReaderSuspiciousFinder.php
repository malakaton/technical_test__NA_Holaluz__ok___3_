<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Application\FindSuspiciousReading;

use App\Electricity\MeterReader\Domain\MeterReaderRepository;
use App\Electricity\MeterReader\Domain\MeterReaderSuspiciousFinder as DomainMeterReaderSuspiciousFinder;
use App\Electricity\MeterReader\Domain\Exception\ClientIdNotDefined;

final class MeterReaderSuspiciousFinder
{
    private DomainMeterReaderSuspiciousFinder $meterReaderSuspiciousFinder;

    public function __construct(
        MeterReaderRepository $repository
    ) {
        $this->meterReaderSuspiciousFinder = new DomainMeterReaderSuspiciousFinder($repository);
    }

    /**
     * @param string $path
     * @param string $sourceType
     * @return array|null
     * @throws ClientIdNotDefined
     */
    public function find(string $path, string $sourceType): ?array
    {
        return $this->meterReaderSuspiciousFinder->__invoke($path, $sourceType);
    }
}