<?php

declare(strict_types=1);

namespace App\Tests\Electricity\MeterReader\Domain;

use App\Electricity\MeterReader\Domain\MeterReaderReading;
use App\Tests\Shared\Domain\IntMother;

final class MeterReaderReadingMother
{
    public static function create(int $value): MeterReaderReading
    {
        return new MeterReaderReading($value);
    }

    public static function random(): MeterReaderReading
    {
        return self::create(IntMother::random());
    }
}