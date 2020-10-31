<?php

declare(strict_types=1);

namespace App\Tests\Electricity\MeterReader\Domain;

use App\Electricity\MeterReader\Domain\MeterReaderMedian;
use App\Tests\Shared\Domain\IntMother;

final class MeterReaderMedianMother
{
    public static function create(int $value): MeterReaderMedian
    {
        return new MeterReaderMedian($value);
    }

    public static function random(): MeterReaderMedian
    {
        return self::create(IntMother::random());
    }
}