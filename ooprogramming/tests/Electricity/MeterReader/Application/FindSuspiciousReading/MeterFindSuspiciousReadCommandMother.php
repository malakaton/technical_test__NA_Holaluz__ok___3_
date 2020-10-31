<?php

declare(strict_types=1);

namespace App\Tests\Electricity\MeterReader\Application\FindSuspiciousReading;

use App\Electricity\MeterReader\Application\FindSuspiciousReading\MeterReaderFindSuspiciousReadCommand;
use App\Tests\Shared\Domain\StringMother;

final class MeterFindSuspiciousReadCommandMother
{
    public static function create(
        string $path,
        string $sourceType
    ): MeterReaderFindSuspiciousReadCommand
    {
        return new MeterReaderFindSuspiciousReadCommand($path, $sourceType);
    }

    public static function random(): MeterReaderFindSuspiciousReadCommand
    {
        return self::create(
            StringMother::random(),
            StringMother::random()
        );
    }
}