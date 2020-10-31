<?php

declare(strict_types=1);

namespace App\Tests\Electricity\MeterReader\Domain;

use App\Electricity\MeterReader\Domain\MeterReaderPeriod;
use App\Tests\Shared\Domain\DateMother;

final class MeterReaderPeriodMother
{
    public static function create(string $value): MeterReaderPeriod
    {
        return new MeterReaderPeriod($value);
    }

    public static function random(): MeterReaderPeriod
    {
        return self::create(DateMother::random());
    }
}