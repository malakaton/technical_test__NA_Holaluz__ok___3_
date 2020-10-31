<?php

declare(strict_types=1);

namespace App\Tests\Electricity\MeterReader\Domain;

use App\Electricity\MeterReader\Domain\MeterReader;
use App\Electricity\MeterReader\Domain\MeterReaderClientId;
use App\Electricity\MeterReader\Domain\MeterReaderMedian;
use App\Electricity\MeterReader\Domain\MeterReaderPeriod;
use App\Electricity\MeterReader\Domain\MeterReaderReading;

final class MeterReaderMother
{
    public static function create(
        MeterReaderClientId $clientId,
        MeterReaderPeriod $period,
        MeterReaderReading $reading,
        MeterReaderMedian $median
    ): MeterReader
    {
        return new MeterReader($clientId, $period, $reading, $median);
    }

    public static function fromRequest(array $values): MeterReader
    {
        return self::create(
            MeterReaderClientIdMother::create($values[MeterReaderClientId::ATTRIBUTE_NAME]),
            MeterReaderPeriodMother::create($values[MeterReaderPeriod::ATTRIBUTE_NAME]),
            MeterReaderReadingMother::create($values[MeterReaderReading::ATTRIBUTE_NAME]),
            MeterReaderMedianMother::create($values[MeterReaderMedian::ATTRIBUTE_NAME])
        );
    }

    public static function random(): MeterReader
    {
        return self::create(
            MeterReaderClientIdMother::random(),
            MeterReaderPeriodMother::random(),
            MeterReaderReadingMother::random(),
            MeterReaderMedianMother::random()
        );
    }
}