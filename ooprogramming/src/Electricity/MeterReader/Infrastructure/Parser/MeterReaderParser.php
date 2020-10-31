<?php

declare(strict_types=1);

namespace App\Electricity\MeterReader\Infrastructure\Parser;

use App\Electricity\MeterReader\Domain\MeterReader;
use App\Electricity\MeterReader\Domain\MeterReaderMedian;
use App\Electricity\MeterReader\Domain\MeterReaderRepository;
use App\Shared\Infrastructure\Parser\Factory\MeterReaderParserFactory;
use App\Shared\Domain\SourceTypeNotFound;

final class MeterReaderParser implements MeterReaderRepository
{
    private const PERCENTAGE_TO_CALCULATE_MIN_MAX_MEDIAN = 0.50;

    /**
     * @param string $path
     * @param string $sourceType
     * @return array
     * @throws SourceTypeNotFound
     */
    public function loadMeterReader(string $path, string $sourceType): array
    {
        $clientReadings = MeterReaderParserFactory::basedOn($path, $sourceType);

        return $clientReadings->__toArray();
    }

    /**
     * @param int $totalRecords
     * @param int $sumReadings
     * @return MeterReaderMedian|null
     */
    public function calculateMedian(int $totalRecords, int $sumReadings): ?MeterReaderMedian
    {
        return new MeterReaderMedian(
            (int)round(
                ($sumReadings / $totalRecords)
            )
        );
    }

    /**
     * @param MeterReader $meterReader
     * @return bool
     */
    public function isSuspiciousReading(MeterReader $meterReader): bool
    {
        return $meterReader->reading()->higherThan(
                new MeterReaderMedian(
                    (int) ($meterReader->median()->value() / self::PERCENTAGE_TO_CALCULATE_MIN_MAX_MEDIAN)
                )
            )
            || $meterReader->reading()->lowerThan(
                new MeterReaderMedian(
                    (int) ($meterReader->median()->value() * self::PERCENTAGE_TO_CALCULATE_MIN_MAX_MEDIAN)
                )
            );
    }
}